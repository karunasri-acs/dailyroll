import { Component, OnInit } from '@angular/core';
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
import { Subject } from 'rxjs';
import swal from 'sweetalert';
import { NestedTreeControl } from '@angular/cdk/tree';

import { MatTreeNestedDataSource } from '@angular/material/tree/data-source/nested-data-source';
import { delay } from 'rxjs/operators';
export type  classification={name :string,description:string,capture_id:string,income_id:string,accountid:string,catid:string,subcatid:string,type:string,income_amount:string,filepath:string,username:string,date:string,count:string,adminstatus:string,pendingstatus:string,pendingamount:string,accountstatus:string,accountadmin:string,symbol:string,children :classification[], newSpecies?:number}

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

  indate:any;
  error: any;
  data: any;
  filename:string;
  filepath:string;
  files : any;
  accountslist:any;
  categorylist:any;
  subcategorylist:any;
  
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
  constructor(private router:Router, private myexpense:MyincomeService) { }

  ngOnInit() {
  
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
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
      this.getsearchAccounts();
      this.dropdown();
      this.dropstatusdown();
  
  }
  dropdown(){
    this.dd=this.dropstatus
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
            for(let item of this.accountslist){
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
  

  }
  updateProduct() {
    var q=3
  debugger
  this.myTable = false;
      this.myexpense.updateincome(this.editedProduct,this.uid,q).subscribe(
        res=>{
          this.results =res
          swal(res)
          this.myTable = true;
       //   this.refreshList();
       if(this.condition =='selectpenstatus'){
        this.selectpenstatus();

       }else if(this.condition =='searchaccount'){
         this.searchAccount();
        }
       else{
        this.getList();

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

   this.myexpense.getAmount(this.editedProduct.subcatid,q).subscribe(
       res => {
         this.amountlist = res;
         console.log(this.amountlist)
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
        if(this.condition =='selectpenstatus'){
          this.selectpenstatus();
  
         }else if(this.condition =='searchaccount'){
           this.searchAccount();
          }
         else{
          this.getList();
  
         }
       // this.refreshList();
      }
    );
  }
  getList() {
   
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
           },
          (err) => {
            this.error = err;
          }
        );
    
  }
  
  public addIncome():void{
   
    debugger;
    this.myTable = false;
    if(this.accountid !=null && this.catid !=null && this.subcatid!=null && this.amount!=null && this.indate!=null ){
          
    this.myexpense.saveIncome(String(this.accountid),String(this.catid),this.subcatid,this.description,this.amount,this.indate,this.addstatus,this.uid).subscribe(
      res=>{
        this.results =res
        swal(res)
        this.myTable = true;
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
          this.accountdataid=null
          this.accountdataid=''
          if(this.condition =='selectpenstatus'){
            this.selectpenstatus();
    
           }else if(this.condition =='searchaccount'){
             this.searchAccount();
            }
           else{
            this.getList();
    
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
}

