import { Component, OnInit,ElementRef } from '@angular/core';
import { MyexpenseService } from '../../services/myexpense.service';
import { Router, ActivatedRoute,NavigationExtras } from '@angular/router';
import swal from 'sweetalert';
import {clone} from  'lodash'
import 'rxjs/add/operator/map';
import { Subject } from 'rxjs';
import { Expense } from './expense';
import { Observable, of  } from 'rxjs';
import { NestedTreeControl } from '@angular/cdk/tree';

import { MatTreeNestedDataSource } from '@angular/material/tree/data-source/nested-data-source';
import { delay } from 'rxjs/operators';
export type  classification={name :string,expense_id:string,accountid:string,catid:string,subcatid:string,type:string,amount:string,filepath:string,username:string,date:string,count:string,children :classification[], newSpecies?:number}


//import { User } from '../user';
@Component({
  selector: 'app-myexpense',
  templateUrl: './myexpense.component.html',
  styleUrls: ['./myexpense.component.css']
})
export class MyexpenseComponent implements OnInit {

  uid:string='';
  //accountlist
  result:any;
  accountid:any;
  amount:string;
  accountiddata:any;
  description : string;
  expdate : any;
  expenses :any;
  error: any;
  data: any;
  editacountid:any;
  editcatid:any;
  filename:string;
  filepath:string;
  files : any;
  type:any;
  catid:any;
  subcatid:any;
  accountslist:any;
  categorylist:any;
  subcategorylist:any;
  editProductForm: boolean = false;
  productForm: boolean = false;
  editProduct: any = {};
  dtOptions: DataTables.Settings = {};
  dtTrigger: Subject<any> = new Subject();
  results: any;
  amountlist:any;
  appDoc:any;
  addexpenses:any;
  myTable:boolean = false;
  include:any;
  mindate:any;
  dropstatus:any;
  dd:any;
  penstatus:any;
  addstatus:any;
  searchaccountslist:any;
  condition:any;
  //treeview
  yeardrop:any;
  selectyear:any;
  droppenstatus:any;
  treeControl: NestedTreeControl<classification>;
  classifications: classification[];
  resdata:any;
  catshow:boolean=false;
  tabledataview:boolean=true;
  treedataview:boolean=false;
  showtype:any;
  //treeview
  constructor(private router:Router, private myexpense:MyexpenseService, private elem:ElementRef) {
    //this.loginService.getusers
   
   }
  
  ngOnInit(){
   
    //this.getuser();
    if(sessionStorage.getItem('uid')!= null){
     // this.email = sessionStorage.getItem('username');
      this.uid = sessionStorage.getItem('uid');
     // console.log(this.uid);
    }
   this.showtype='table';
    this.dropstatus=[
      {
      "status":"non-pending"
      },
      {
        "status":"pending"
      }
    
    ] 
    this.getList();
    this.getAccounts();
    this.dropdown();
    this.dropstatusdown();
    this.getsearchAccounts();
  }
  getyear(){
    var q=1
    debugger;
   
   this.myexpense.getyear(this.uid,q).subscribe(
      res => {
        this.yeardrop = res;
       
        for(let item of this.yeardrop){
          var year = item.year
  
        }
       this.selectyear =year;
       if(this.selectyear !=''){
          this.searchtree();
        }
        console.log(this.selectyear)
       },
     
    );
  }
  dropstatusdown(){
      this.dd=this.dropstatus
      for(let item of this.dd){
        var prod = item.status
      }
      this.droppenstatus =prod;
  }
  searchtree(){
    if(this.showtype='tree'){
    var q=2
  debugger;
  this.catshow=false;
  
  this.myexpense.getexpensestree(this.uid,this.accountiddata,this.droppenstatus,this.selectyear,q).subscribe(
    res => {
      this.resdata=res;
      //this.classification=this.resdata
   //alert(this.resdata);
      this.classifications=this.resdata
      this.treeControl= new NestedTreeControl<classification>(node =>  of(node.children))
      this.catshow=true;
     
     },
   
  );
    }else{
      var q=4;
      this.myTable = false;
        // this.doughnutChartLabels=[];
      //this.doughnutChartData =[];
      this.myexpense.searchAccount(this.uid,this.accountiddata,this.droppenstatus,this.selectyear,q).subscribe(
        res => {
          this.expenses = res;
          this.myTable = true;
          this.condition = 'searchaccount';
         // this.userservice.alertMsg(this.expenses);
        });
  


    }



  }
  getAccounts() {
    var q=1
        debugger;
      
        this.myexpense.getAccountsList(this.uid,q).subscribe(
          res => {
            this.accountslist = res;
            console.log(this.accountslist)
            for(let item of this.accountslist){
              var aid = item.account_id

            }
           
            this.accountiddata =aid;
            if(this.accountiddata !=''){
              this.getyear();
            }
           },
          (err) => {
            this.error = err;
          }
        );
  }
  treeview(){
    this.showtype='tree';
    this.searchtree();
    this.tabledataview=false;
    this.treedataview=true;
  }
  tableview(){
    this.showtype='table';
    this.tabledataview=true;
    this.treedataview=false;
  }
  dropdown(){
    this.dd=this.dropstatus
    }
  viewDoc(item:any){
    let docid = item.expense_id
    let q = 3
    this.myexpense.getDoc(docid,q).subscribe(
      res =>{
        this.appDoc = res
   //     this.userservice.alertMsg(res)
   console.log(this.appDoc);
      }
    )
  }
 
  selectpenstatus(){
    debugger;
    var q=7;
    this.myTable = false;
      // this.doughnutChartLabels=[];
    //this.doughnutChartData =[];
    this.myexpense.searchstatus(this.uid,this.accountiddata,this.penstatus,q).subscribe(
      res => {
        this.expenses = res;
        this.myTable = true;
        this.condition = 'selectpenstatus';
       // this.userservice.alertMsg(this.expenses);
      });
    //this.refreshList();
  }
  getList() {
    var q=1
    this.myTable = false;
        debugger;
        //this.userservice.alertMsg(this.accountiddata);
        this.myexpense.getAll(this.uid,this.accountiddata,q).subscribe(
          res => {
            this.expenses = res;
            this.myTable = true;
            console.log(this.expenses);
          },
          (err) => {
            this.error = err;
          }
        );
      
  }
      
  showEditProductForm(item: Expense) {

   console.log(item)
    if(!item) {
    
      this.productForm = false;
      return;
    }
    this.editProductForm = true;
    this.editProduct = clone(item);
    this.editacountid=this.editProduct.accountid;
    this.editcatid=this.editProduct.catid;
   
    if(this.editacountid != null){
       var q=2
      var type=1;
      this.myexpense.getCategoryList(this.editacountid,type,q).subscribe(
        res => {
          this.categorylist = res;
          console.log(this.categorylist)
         },
        (err) => {
          this.error = err;
        }
      );
      if(this.editcatid != null){

        var q=3
    
        this.myexpense.getSubCategoryList(this.editcatid,q).subscribe(
              res => {
                this.subcategorylist = res;
                console.log(this.subcategorylist)
               },
              (err) => {
                this.error = err;
              }
            );
        

      }



    }

  }
  updateProduct() {
    //this.userservice.alertMsg("hii");
      let files= this.elem.nativeElement.querySelector('#Upload').files;
      debugger;
      this.myTable = false;
      if(files.length > 0){
      let formdata = new FormData();
      let file = files[0];
      let filename= this.uid+"-"+file.name;
    // let filename= this.getfilename(this.uid);
      debugger;
      formdata.append('Upload',file,filename);
      this.myexpense.uploadImage1(formdata).subscribe
      (res => this.updateExpense(res));
    }else{
      this.updateExpense1();
    }
   
  }
  onChangeRecord(){
    debugger;
if(this.include !=''){
 

}
    
  }
  public updateExpense(data:any):void{
    //let filename =this.files.filename;
      debugger;
      this.myTable = false;
    this.filepath = data.filename;
    //console.log(this.filepath)
    debugger;
    //this.myexpense.updateProduct(this.editedProduct);
    
    this.myexpense.updateProduct(this.editProduct,this.uid,this.filepath).subscribe(
      res => {
        swal(res);
        this.myTable = true;
       if(this.condition =='selectpenstatus'){
        this.selectpenstatus();

       }else if(this.condition =='searchaccount'){
        
        }
       else{
          this.refreshList();

       }
       
         },
    );
 
    }
    public updateExpense1():void{

      //let filename =this.files.filename;
      //let filepath = "aaaa";
      //console.log(this.filepath)
      debugger;
      this.myTable = false;
      this.filepath = 'aaaa';
      var q=1
      this.myexpense.updateProduct1(this.editProduct,this.uid,this.filepath,q).subscribe(
        res => {
        swal(res);
        this.myTable = true;
        if(this.condition =='selectpenstatus'){
          this.selectpenstatus();
  
         }else if(this.condition =='searchaccount'){
          // this.searchAccount();
          }
         else{
            this.refreshList();
  
         }
         },
      );
    
      }
         getsearchAccounts() {
        var q=10
            debugger;
          
            this.myexpense.getSearchAccountsList(this.uid,q).subscribe(
              res => {
                this.searchaccountslist = res;
                console.log(this.searchaccountslist)
               },
              (err) => {
                this.error = err;
              }
            );
          }
          selectacc() {
          //  this.userservice.alertMsg(this.accountid);
            
        var q=2
      var type=1
           // this.userservice.alertMsg(this.accountid);
            this.myexpense.getCategoryList(this.accountid,type,q).subscribe(
              res => {
                this.categorylist = res;
                console.log(this.categorylist)
               },
              (err) => {
                this.error = err;
              }
            );
        var q=5
    
           // this.userservice.alertMsg(this.accountid);
            this.myexpense.getMindate(this.accountid,q).subscribe(
              res => {
                this.mindate = res;
                
                console.log(this.mindate)
               },
              (err) => {
                this.error = err;
              }
            );
        
          } 
          selecteditacc(){
            var q=2
            var type=1

                  //this.userservice.alertMsg(this.editProduct.accountid);
                  this.myexpense.getCategoryList(this.editProduct.accountid,type,q).subscribe(
                    res => {
                      this.categorylist = res;
                      console.log(this.categorylist)
                     },
                    (err) => {
                      this.error = err;
                    }
                  );

          }
          selectsubcat(){
           // this.userservice.alertMsg(this.subcatid);
           var q=6
    
          this.myexpense.getAmount(this.subcatid,q).subscribe(
              res => {
                this.amountlist = res;
                console.log(this.amountlist)
                for (let key of this.amountlist) {
                  console.log("object:", key);
                    
            this.amount=key.amount
                    }
               },
              (err) => {
                this.error = err;
              }
            );
        

          }
          selecteditsubcat(){
           // this.userservice.alertMsg(this.subcatid);
           var q=6
    
          this.myexpense.getAmount(this.editProduct.subcatid,q).subscribe(
              res => {
                this.amountlist = res;
                console.log(this.amountlist)
               },
              (err) => {
                this.error = err;
              }
            );
        

          }
          selectcat() {
            //this.userservice.alertMsg(this.catid);
            
        var q=3
    
        this.myexpense.getSubCategoryList(this.catid,q).subscribe(
              res => {
                this.subcategorylist = res;
                console.log(this.subcategorylist)
               },
              (err) => {
                this.error = err;
              }
            );
        
          }
          selecteditcat() {
           // this.userservice.alertMsg(this.editProduct.catid);
            
        var q=3
    
        this.myexpense.getSubCategoryList(this.editProduct.catid,q).subscribe(
              res => {
                this.subcategorylist = res;
                console.log(this.subcategorylist)
               },
              (err) => {
                this.error = err;
              }
            );
        
          }
          removeProduct() {
           
            debugger;
            this.myTable = false;
            this.myexpense.deleteProduct(this.editProduct).subscribe(
              data=>{
                this.result = data;
              swal(this.result);
                this.myTable = true;
                if(this.condition =='selectpenstatus'){
                  this.selectpenstatus();
          
                 }else if(this.condition =='searchaccount'){
                  // this.searchAccount();
                  }
                 else{
                    this.refreshList();
          
                 }
              }
            );
          
          }
          public uploadImage(): void{
            if(this.accountid !=null && this.catid !=null && this.subcatid!=null && this.amount!=null && this.expdate!=null  ){
            let files= this.elem.nativeElement.querySelector('#fileToUpload').files;
            this.myTable = false;
           debugger;
           if(files.length > 0){
            let formdata = new FormData();
            let file = files[0];
            let filename= this.uid+"-"+file.name;
           // let filename= this.getfilename(this.uid);
            debugger;
            formdata.append('fileToUpload',file,filename);
            this.myexpense.uploadImage(formdata).subscribe
            (res => this.addExpense(res));
           }else{
             this.addExpense1();
           }
          }else{

            swal('please select all star marked fields');


          }
          }
          public refreshList(){
             this.getList();
           }
         public addExpense(data:any):void{

          //let filename =this.files.filename;
          this.filepath = data.filename;
          //console.log(this.filepath)
          debugger;
          console.log(this.expdate);
          this.myexpense.saveExpense(String(this.accountid),String(this.catid),String(this.subcatid),this.description,this.amount,this.expdate,this.uid,this.filepath,this.addstatus).subscribe(
            res => {
             swal(res);
             if(this.condition =='selectpenstatus'){
              this.selectpenstatus();
      
             }else if(this.condition =='searchaccount'){
              // this.searchAccount();
              }
             else{
                this.refreshList();
      
             }
             this.myTable = true;
             this.accountid =null
             this.catid = null
             this.subcatid = null
             this.amount = null
             this.expdate = null
             this.description = null
             this.description = ''
             this.accountid =''
             this.catid = ''
             this.subcatid = ''
             this.amount = null
             this.expdate = null
             this.addstatus =''
             this.addstatus =null
           
             }
           
          );
      
          
          }
          public addExpense1():void{
            //let filename =this.files.filename;
            let filepath = "aaaa";
            //console.log(this.filepath)
            debugger;
            this.myTable = false;
            console.log(this.expdate);
            this.myexpense.saveExpense(String(this.accountid),String(this.catid),String(this.subcatid),this.description,this.amount,this.expdate,this.uid,filepath,this.addstatus).subscribe(
             res => {
             swal(res);
             if(this.condition =='selectpenstatus'){
              this.selectpenstatus();
      
             }else if(this.condition =='searchaccount'){
               //this.searchAccount();
              }
             else{
                this.refreshList();
      
             } if(this.condition =='selectpenstatus'){
              this.selectpenstatus();
      
             }else if(this.condition =='searchaccount'){
              // this.searchAccount();
              }
             else{
                this.refreshList();
      
             }
            
             this.accountid =null
             this.catid = null
             this.subcatid = null
             this.amount = null
             this.expdate = null
             this.description = null
             this.description = ''
             this.accountid =''
             this.catid = ''
             this.subcatid = ''
             this.amount = null
             this.expdate = null
             this.accountiddata=null
             this.accountiddata=''
             this.addstatus =''
             this.addstatus =null
            
             }
           
            );
            }
         
            selectstatus(){
              
            }
}