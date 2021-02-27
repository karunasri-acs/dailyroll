import { Component, OnInit,ElementRef} from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { Income } from './income';
//import { FormControl, FormGroup } from '@angular/forms';
import { Http , Response } from '@angular/http';
import { HttpClient, HttpErrorResponse, HttpParams } from '@angular/common/http';
import { ModalDirective } from 'ngx-bootstrap/modal';
import { Observable, of  } from 'rxjs';
import 'rxjs/add/operator/map';
import {clone} from  'lodash'
import { MyincomeService } from '../../services/myincome.service';
import { CategoryService } from '../../services/category.service';
import { Subject } from 'rxjs';
import swal from 'sweetalert';
import { NestedTreeControl } from '@angular/cdk/tree';

import { MatTreeNestedDataSource } from '@angular/material/tree/data-source/nested-data-source';
import { delay } from 'rxjs/operators';
export type  classification={name :string,description:string,capture_id:string,income_id:string,accoun:string,catid:string,subcatid:string,type:string,income_amount:string,filepath:string,username:string,tr_date:string,count:string,adminstatus:string,pendingstatus:string,pendingamount:string,accountstatus:string,accountadmin:string,symbol:string,children :classification[], newSpecies?:number}

@Component({
  selector: 'app-myincome',
  templateUrl: './myincome.component.html',
  styleUrls: ['./myincome.component.css']
})
export class MyincomeComponent implements OnInit {
  nameList :any;  
  account_id: Number; 
  //accountlist:[]
  catList: any;  
  accountid:any;
  accountdataid:any;
  catid:any;
  subcatid:any;
  uid:string='';
  amount:string;
  description : string;
  date :string;
subcatdesc:any;
subcatamount:any;
subcatdate:any;
  indate:any;
  error: any;
  data: any;
  filename:string;
  filepath:string;
  files : any;
  accountslist:any;
  categorylist:any;
  subcategorylist:any;
  appDoc:any;
  editProductForm: boolean = false;
  productForm: boolean = false;
  editedProduct: any = {};
  dtOptions: DataTables.Settings = {};
  dtTrigger: Subject<any> = new Subject();
  results: any;
  editacountid:any;
  editcatid:any;
  myTable:boolean = false;
  mindate:any;
  dropstatus:any;
  dd:any;
  penstatus:any;
  addstatus:any;
  searchaccountslist:any;
  incomeListbynormal:any;
  incomeData:any;
  condition:any;
  amountlist:any;
  //treestruct
  yeardrop:any;
  selectyear:any;
  resdata:any;
  showtype:any;
  catshow:any;
  treeControl: NestedTreeControl<classification>;
  classifications: classification[];
  tabledataview:boolean=true;
  treedataview:boolean=false;
  showid:any;
  selecttype:any;
  mytablecontacts:boolean=false;
  mycontacts:any;
  display:boolean=true;
  dropsstatus:any;
  resalert:any;
  constructor(private router:Router, private elem:ElementRef, private myexpense:MyincomeService,private category:CategoryService) { }

  ngOnInit() {
  
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
    this.dropstatus=[
     
      {
        "status":"pending"
      },
      {
        "status":"non-pending"
      },
      {
        "status":"Both"
        }
    
    ] 
    this.dropsstatus=[
      {
      "status":"non-pending"
      },
      {
        "status":"pending"
      }
    
    ]
      this.getsearchAccounts();
      this.getAccounts();
      this.dropdown();
      this.dropstatusdown();
  
  }
  dropdown(){
    this.dd=this.dropsstatus
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
    searchtree(){
   
      if(this.showtype =='tree'){
      var q=2
    debugger;
    this.catshow=false;
    
    this.myexpense.getincometree(this.uid,this.accountdataid,this.penstatus,this.selectyear,q).subscribe(
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
        var q=1
   
    this.myTable = false;
    this.myexpense.getIncomeList(this.uid,this.accountdataid,this.penstatus,this.selectyear,q).subscribe(
      res => {
        this.incomeListbynormal = res;
      
        this.myTable = true;
      // console.log(this.incomelist);
      },
      (err) => {
        this.error = err;
      }
    );
   
      
      }
  
  
  
    }
    viewDoc(item:any){
      let docid = item.income_id
     // alert(docid);
      let q = 8
      this.myexpense.getDoc(docid,q).subscribe(
        res =>{
          this.appDoc = res
     //     this.userservice.alertMsg(res)
     console.log(this.appDoc);
        }
      )
    }
  getAccounts() {
    var q=1
        debugger;
     
        this.myexpense.getAccountsList(this.uid,q).subscribe(
          res => {
            this.accountslist = res;
          
            console.log(this.accountslist)
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
    dropstatusdown(){
        this.dd=this.dropstatus
        for(let item of this.dd){
          var prod = item.status
        }
        this.penstatus =prod;
    }
   getsearchAccounts() {
    var q=10
        debugger;
      
        this.myexpense.getSearchAccountsList(this.uid,q).subscribe(
          res => {
            this.searchaccountslist = res;
          
            console.log(this.searchaccountslist)
            for(let item of this.searchaccountslist){
              var aid = item.account_id

            }
           
            this.accountdataid =aid;
            if(this.accountdataid !=''){
              this.getyear();
            }
           },
          (err) => {
            this.error = err;
          }
        );
      }
   editMember(item: Income) {
    if(!item) {
     
      this.productForm = false;
      return;
    }
    console.log(item)
    this.editProductForm = true;
    this.editedProduct = clone(item);
    this.editacountid=this.editedProduct.accoun;
    this.editcatid=this.editedProduct.cat_id;
    this.subcatdate=this.editedProduct.tr_date;
  
this.accountid=this.editedProduct.accoun;
    if(this.editacountid != null){
     // this.userservice.alertMsg(this.editacountid)
      var q=2
  var type=2
  this.myTable = false;
     //   this.userservice.alertMsg(this.accountid);
        this.myexpense.getCategoryList(this.editacountid,type,q).subscribe(
          res => {
            this.categorylist = res;
            this.myTable = true;
            console.log(this.categorylist)
           },
          (err) => {
            this.error = err;
          }
        );
      }
     if(this.editcatid != null){
      var q=3
      //this.userservice.alertMsg(this.catid)
      this.myexpense.getSubCategoryList(this.editcatid,q).subscribe(
            res => {
              this.myTable = false;
              this.subcategorylist = res;
              this.myTable = true;
              console.log(this.subcategorylist)
             },
            (err) => {
              this.error = err;
            }
          );
            }
            var q=5
    
            // this.userservice.alertMsg(this.accountid);
             this.myexpense.getMindate(this.editedProduct.accoun,q).subscribe(
               res => {
                 this.mindate = res;
               //  this.userservice.alertMsg('hj');
                 console.log(this.mindate)
                 
                },
               (err) => {
                 this.error = err;
               }
             );

  }
  showeditsubac(item: Income) {
    if(!item) {
     
      this.productForm = false;
      return;
    }
    console.log(item)
    this.editProductForm = true;
    this.editedProduct = clone(item);
    this.showid=this.editedProduct.subcat_id;
   
    this.selecttype='sub-account';
this.getContact();
  }
  showAccForm(item: Income) {
    if(!item) {
     
      this.productForm = false;
      return;
    }
    console.log(item)
    this.editProductForm = true;
    this.editedProduct = clone(item);
    this.showid=this.editedProduct.cat_id;
    this.selecttype='account';
this.getContact();
  }
  showBusinessForm(item: Income) {
    if(!item) {
     
      this.productForm = false;
      return;
    }
    console.log(item)
    this.editProductForm = true;
    this.editedProduct = clone(item);
    this.showid=this.editedProduct.accoun;
    this.selecttype='business';
this.getContact();
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
      (res => this.updateIncome(res));
    }else{
      this.updateIncome1();
    }
    this.elem.nativeElement.querySelector('#Upload').value="";
    // this.myInputVariable.nativeElement.value = "";
     files=''
     files=null 
  }
  public updateIncome(data:any):void{
    //let filename =this.files.filename;
    var q=7
      debugger;
      this.myTable = false;
    this.filepath = data.filename;
    //console.log(this.filepath)
    debugger;
    //this.myexpense.updateProduct(this.editedProduct);
    
    this.myexpense.updateincome1(this.editedProduct,this.uid,q,this.filepath).subscribe(
      res => {
        this.resalert=res;
        if(this.results=='Updated successfully.'){
          swal(res);
          this.searchtree();
      }
      else{
        swal({
          title: "Are you sure?",
          text: this.results,
          icon: "warning",
          buttons: [true, true],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.updateincome();
            
          } else {
         
          }
        });

       }       
       
      
         },
    );
 
    }
  updateIncome1() {
    var q=3
  debugger
  this.myTable = false;
      this.myexpense.updateincome(this.editedProduct,this.uid,q).subscribe(
        res=>{
          this.results =res
         if(this.results=='Updated successfully.'){
            swal(res);
            this.searchtree();
        }
        else{
          swal({
            title: "Are you sure?",
            text: this.results,
            icon: "warning",
            buttons: [true, true],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              this.updateincome();
              
            } else {
           
            }
          });

         }       
         
          
         
    
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
//alert(this.editedProduct.subcat_id);
   this.myexpense.getAmount(this.editedProduct.subcat_id,q).subscribe(
       res => {
         this.amountlist = res;
         console.log(this.amountlist)
         for(let item of this.amountlist){
          var aid = item.amount

        }
      
        this.subcatamount =aid;
        },
       (err) => {
         this.error = err;
       }
     );
 

   }
  searchAccount(){
    debugger;
    var q=4;
      // this.doughnutChartLabels=[];
    //this.doughnutChartData =r[];
    this.myTable = false;
    this.myexpense.searchAccount(this.uid,this.accountdataid,this.penstatus,q).subscribe(
      res => {
        this.incomeListbynormal = res;
        this.myTable = true;
        
        this.condition = 'searchaccount';
      });

     
  }
  selectpenstatus(){
    debugger;
    var q=5;
    this.myTable = false;
      // this.doughnutChartLabels=[];
    //this.doughnutChartData =[];
    this.myexpense.searchstatus(this.uid,this.accountdataid,this.penstatus,q).subscribe(
      res => {
        this.incomeListbynormal = res;
        this.myTable = true;
        this.condition = 'selectpenstatus';
       // this.userservice.alertMsg(this.expenses);
      });
    //this.refreshList();
  }
  removeProduct() {
    var q=2
    debugger;
    let income =this.editedProduct.income_id
    //this.userservice.alertMsg(income)
    this.myexpense.deleteProduct(income,q).subscribe(
      res=>{
        this.results =res
        swal(res)
      this.searchtree();
      }
    );
  }
 
  

  selectacc() {
        //this.userservice.alertMsg(this.accountid);
        
    var q=2
  var type=2
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
            // alert(this.mindate);
           //  this.userservice.alertMsg('hj');
             console.log(this.mindate)
             
            },
           (err) => {
             this.error = err;
           }
         );
  } 
  
  selecteditacc() {
        //this.userservice.alertMsg(this.accountid);
        
    var q=2
  var type=2
       // this.userservice.alertMsg(this.accountid);
        this.myexpense.getCategoryList(this.editedProduct.accoun,type,q).subscribe(
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
         this.myexpense.getMindate(this.editedProduct.accoun,q).subscribe(
           res => {
             this.mindate = res;
            // alert(this.mindate);
           //  this.userservice.alertMsg('hj');
             console.log(this.mindate)
             
            },
           (err) => {
             this.error = err;
           }
         );
  } 
  
  selectcat() {
      //  this.userservice.alertMsg(this.catid);
        
    var q=3

    this.myexpense.getSubCategoryList(this.catid,q).subscribe(
          res => {
            this.subcategorylist = res;
            console.log(this.subcategorylist)
            //alert(this.subcategorylist);
           },
          (err) => {
            this.error = err;
          }
        );
    
  }
  
  editselectcat() {
      //  this.userservice.alertMsg(this.catid);
        
    var q=3

    this.myexpense.getSubCategoryList(this.editedProduct.cat_id,q).subscribe(
          res => {
            this.subcategorylist = res;
            console.log(this.subcategorylist)
           
           },
          (err) => {
            this.error = err;
          }
        );
    
  }
  
  public addIncome():void{
   
    let files= this.elem.nativeElement.querySelector('#fileToUpload').files;
   
  
   debugger;
   
   if(files.length > 0){
    let formdata = new FormData();
    let file = files[0];
    let filename= this.uid+"-"+file.name;
   // let filename= this.getfilename(this.uid);
    debugger;
    formdata.append('fileToUpload',file,filename);
    this.myexpense.uploadImage(formdata).subscribe
    (res => this.addIncome2(res));
   }else{
     this.addIncome1();
   }
  
   this.elem.nativeElement.querySelector('#fileToUpload').value="";
   // this.myInputVariable.nativeElement.value = "";
    files=''
    files=null 
  } 
  
  public addIncome1():void{
   
    debugger;

    if(this.accountid !=null && this.catid !=null && this.subcatid!=null && this.amount!=null && this.indate!=null ){
          
    this.myexpense.saveIncome(String(this.accountid),String(this.catid),this.subcatid,this.description,this.amount,this.indate,this.addstatus,this.uid).subscribe(
      res=>{
        this.results =res
        if(this.results=='Data saved successfully.'){
        swal(res);
         this.searchtree();
        this.myTable = true;
      
          this.catid = null
          this.subcatid = null
          this.amount = null
          this.indate = null
         this.description= null
         this.description =''
         this.catid = ''
          this.subcatid = ''
          this.amount = null
          this.indate = null
          this.accountdataid=null
          this.accountdataid=''
      }else{
        swal({
          title: "Are you sure?",
          text: this.results,
          icon: "warning",
          buttons: [true, true],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.saveincome();
            
          } else {
         
          }
        });
      }
      //this.getList();
      }
    );
    } 
    else{

      //this.getList();
      swal('Please enter all values');
    
    }
  } 
  public addIncome2(data:any):void{
  
    this.filepath = data.filename;
    debugger;

    if(this.accountid !=null && this.catid !=null && this.subcatid!=null && this.amount!=null && this.indate!=null ){
          
    this.myexpense.saveIncome1(String(this.accountid),String(this.catid),this.subcatid,this.description,this.amount,this.indate,this.addstatus,this.uid,this.filepath).subscribe(
      res=>{
        this.results =res
        if(this.results=='Data saved successfully.'){
        swal(res);
         this.searchtree();
     
      
          this.catid = null
          this.subcatid = null
          this.amount = null
          this.indate = null
         this.description= null
         this.description =''
         this.catid = ''
          this.subcatid = ''
          this.amount = null
          this.indate = null
          this.accountdataid=null
          this.accountdataid=''
      }else{
        swal({
          title: "Are you sure?",
          text: this.results,
          icon: "warning",
          buttons: [true, true],
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            this.saveincome1();
            
          } else {
         
          }
        });
      }
      //this.getList();
      }
    );
    } 
    else{

      //this.getList();
      swal('Please enter all values');
    
    }
  } 
  public uploadImage(): void{
     let files= this.elem.nativeElement.querySelector('#filedata').files;
   
  
   debugger;
   
   if(files.length > 0){
    let formdata = new FormData();
    let file = files[0];
    let filename= this.uid+"-"+file.name;
   // let filename= this.getfilename(this.uid);
    debugger;
    formdata.append('filedata',file,filename);
    this.myexpense.uploadImage2(formdata).subscribe
    (res => this.addincomesub1(res));
   }else{
     this.addincomesub();
   }
   this.elem.nativeElement.querySelector('#filedata').value="";
   // this.myInputVariable.nativeElement.value = "";
    files=''
    files=null
  }
  addincomesub(){

    debugger;
   
    if(this.subcatamount!=null && this.subcatdate!=null ){
          
    this.myexpense.saveSubIncome(String(this.editedProduct.accoun),String(this.editedProduct.cat_id),this.editedProduct.subcat_id,this.subcatdesc,this.subcatamount,this.subcatdate,this.addstatus,this.uid).subscribe(
      res=>{
        this.results =res
        if(this.results=='Data saved successfully.'){
        swal(res)
        this.searchtree();
        
        this.accountid =null
          this.catid = null
          this.subcatid = null
          this.amount = null
          this.indate = null
         this.description= null
         this.description =''
          this.accountid =''
          this.catid = ''
          this.subcatid = ''
          this.amount = null
          this.indate = null
          
        }else{
          swal({
            title: "Are you sure?",
            text: this.results,
            icon: "warning",
            buttons: [true, true],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              this.saveSubincome();
              
            } else {
            
            }
          });
        }
      //this.getList();
      }
    );
    } 
    else{

      //this.getList();
      swal('Please enter all values');
    
    }


  } 
  addincomesub1(data:any):void{
  
    this.filepath = data.filename;
    debugger;
 
    if(this.subcatamount!=null && this.subcatdate!=null ){
          
    this.myexpense.saveSubIncome1(String(this.editedProduct.accoun),String(this.editedProduct.cat_id),this.editedProduct.subcat_id,this.subcatdesc,this.subcatamount,this.subcatdate,this.addstatus,this.uid,this.filepath).subscribe(
      res=>{
        this.results =res
        if(this.results=='Data saved successfully.'){
        swal(res)
        this.searchtree();
        
        this.accountid =null
          this.catid = null
          this.subcatid = null
          this.amount = null
          this.indate = null
         this.description= null
         this.description =''
          this.accountid =''
          this.catid = ''
          this.subcatid = ''
          this.amount = null
          this.indate = null
          
        }else{
          swal({
            title: "Are you sure?",
            text: this.results,
            icon: "warning",
            buttons: [true, true],
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              this.saveSubincome1();
              
            } else {
            
            }
          });
        }
      //this.getList();
      }
    );
    } 
    else{

      //this.getList();
      swal('Please enter all values');
    
    }


  } 

  showbusicon(){
    this.showid=this.accountid;
    //alert(this.showid);
    this.selecttype='business';
    if(this.showid !=null && this.showid !='undefined'){
     // alert(this.showid);
      this.getContact();
    }
    else{
      this.display=false;
        swal('Please Select Business');

    }
   

  }
  showacccon(){
    this.showid=this.catid;
    this.selecttype='account';
    if(this.showid !=null && this.showid !='undefined'){
      this.getContact();
    }
    else{
      this.display=false;
        swal('Please Select Account');

    }
  }
  showsubacccon(){
   
    this.showid=this.subcatid;
   // alert(this.showid);
    this.selecttype='sub-account';
    if(this.showid !=null && this.showid !='undefined'){
      this.getContact();
    }
    else{
      this.display=false;
        swal('Please Select Sub-Account');

    }
  }
  getContact(){
    var q=8
    this.mytablecontacts=false
    debugger;
 
    this.category.gettreeContact(this.showid,this.selecttype,q).subscribe(
      res => {
        this.mycontacts = res;
       
     this.mytablecontacts=true
      },
  
  
    )
  
      
    }
    saveincome(){
      this.myTable = false;
       this.myexpense.saveIncm(String(this.accountid),String(this.catid),this.subcatid,this.description,this.amount,this.indate,this.addstatus,this.uid).subscribe(
   
      res=>{
          this.results =res
          swal(res)
          this.searchtree();
          this.myTable = true;
         
            this.catid = null
            this.subcatid = null
            this.amount = null
            this.indate = null
            this.description= null
            this.description =''
            this.catid = ''
            this.subcatid = ''
            this.amount = null
            this.indate = null
            
           
        //this.getList();
        }
      );
    }
    saveincome1(){
      this.myTable = false;
       this.myexpense.saveIncm1(String(this.accountid),String(this.catid),this.subcatid,this.description,this.amount,this.indate,this.addstatus,this.uid,this.filepath).subscribe(
   
      res=>{
          this.results =res
          swal(res)
          this.searchtree();
          this.myTable = true;
         
            this.catid = null
            this.subcatid = null
            this.amount = null
            this.indate = null
            this.description= null
            this.description =''
            this.catid = ''
            this.subcatid = ''
            this.amount = null
            this.indate = null
            
           
        //this.getList();
        }
      );
    }
    saveSubincome(){
      this.myTable = false;
      this.myexpense.saveSubIncome(String(this.editedProduct.accoun),String(this.editedProduct.cat_id),this.editedProduct.subcat_id,this.subcatdesc,this.subcatamount,this.subcatdate,this.addstatus,this.uid).subscribe(
   
      res=>{
          this.results =res
          swal(res)
          this.searchtree();
          this.myTable = true;
         
            this.catid = null
            this.subcatid = null
            this.amount = null
            this.indate = null
            this.description= null
            this.description =''
            this.catid = ''
            this.subcatid = ''
            this.amount = null
            this.indate = null
            
           
        //this.getList();
        }
      );
    }
    saveSubincome1(){
      this.myTable = false;
      this.myexpense.saveSubIncome1(String(this.editedProduct.accoun),String(this.editedProduct.cat_id),this.editedProduct.subcat_id,this.subcatdesc,this.subcatamount,this.subcatdate,this.addstatus,this.uid,this.filepath).subscribe(
   
      res=>{
          this.results =res
          swal(res)
          this.searchtree();
          this.myTable = true;
         
            this.catid = null
            this.subcatid = null
            this.amount = null
            this.indate = null
            this.description= null
            this.description =''
            this.catid = ''
            this.subcatid = ''
            this.amount = null
            this.indate = null
            
           
        //this.getList();
        }
      );
    }
    updateincome(){
      var q=6;  
      this.myexpense.updateincome(this.editedProduct,this.uid,q).subscribe(
        res=>{
          this.results =res
         
            swal(res);
            this.searchtree();
         
        }
      );

    }
   
    updateincomefile(){
      var q=9;  
      this.myexpense.updateincome1(this.editedProduct,this.uid,q,this.filepath).subscribe(
        res=>{
          this.results =res
         
            swal(res);
            this.searchtree();
         
        }
      );

    }
   
  }



