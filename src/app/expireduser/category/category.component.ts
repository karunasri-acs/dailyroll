import { Component, OnInit,ElementRef } from '@angular/core';
import { CategoryService } from '../../services/category.service';
import { Router, ActivatedRoute,NavigationExtras } from '@angular/router';
import { DataTablesModule } from 'angular-datatables';
import { Subject } from 'rxjs';
import {clone} from  'lodash'
import { Category } from './category';
import { SubCategory } from './subcategory';

import swal from 'sweetalert';
@Component({
  selector: 'app-category',
  templateUrl: './category.component.html',
  styleUrls: ['./category.component.css']
})
export class CategoryComponent implements OnInit {
  myTable:boolean=false
  mysubTable:boolean=false
  dtOptions: DataTables.Settings = {};
  dtTrigger: Subject<any> = new Subject();
  dtOptions1: DataTables.Settings = {};
  dtTrigger1: Subject<any> = new Subject();
  uid:string='';
  categorylist :any;
  subcategorylist :any;
  error: any; 
  accountid:any;
  accountslist:any;
  data:any;
  messagetype:any;
  type:any;
  catname:any;
  catlist:any;
  catid:any;
  categoryid:any;
  subcatname:any;
  defaultamount:any;
  subcatnamebycat:any;
  subcatdefaultamount:any;

  editProductForm: boolean = false;
  productForm: boolean = false;
  editedProduct: any = {};
  editCategoryForm: boolean = false;
  SubCategoryForm: boolean = false;
  editedSubCategory: any = {};
  constructor(private router:Router, private myexpense:CategoryService, private elem:ElementRef) {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
      // console.log(this.uid);
     }
  }

  ngOnInit() {
    
   
    //this.getuser();
    
    this.data=[
      {
      "catname":"expenses"
      },
      {
        "catname":"income"
        }
    
      ] 
      this.getAccounts();
    this.getCategoryList();
    this.getSubCategoryList();
   
   this.getCategory();
    this.getcattype();
  }
 
  getCategoryList() {
    var q=1
        debugger;
        this.myexpense.getCategories(this.uid,q).subscribe(
          res => {
            this.categorylist = res;
            this.myTable = true;
           console.log(this.categorylist);
          },
          (err) => {
            this.error = err;
          }
        );
      }
  getSubCategoryList() {
        var q=3
            debugger;
            this.mysubTable = false;
            this.myexpense.getSubCategories(this.uid,q).subscribe(
              res => {
                this.subcategorylist = res;
                //this.dtTrigger1.next();
                this.mysubTable = true;
                console.log(this.subcategorylist);
              },
              (err) => {
                this.error = err;
              }
            );
      }
      private refreshList1(){
    
        this.getCategoryList();
       // this.getSubCategoryList();
      // this.myTable = true;
       }
       private refreshList(){
    
       // this.getCategoryList();
        this.getSubCategoryList();
        this.mysubTable = true;
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
  getCategory() {
        var q=5;
            debugger;
            this.myexpense.getCatList(this.uid,q).subscribe(
              res => {
                this.catlist = res;
                console.log(this.catlist)
               },
              (err) => {
                this.error = err;
              }
            );
          }
          catinactive(){

            var q=7
            this.myTable = false;
            this.myexpense.catInactive(this.editedProduct,q).subscribe(
              res=>{
         
                swal(res)
           
                this.refreshList1();
              }
            )
          

          }
          catactive(){

            var q=8
            this.myTable = false;
            this.myexpense.catactive(this.editedProduct,q).subscribe(
              res=>{
         
                swal(res)
           
                this.refreshList1();
              }
            )
      

          }
          subcatinactive(){
debugger
            var q=9
            this.myexpense.subcatInactive(this.editedSubCategory,q).subscribe()
            this.refreshList();

          }
          subcatactive(){

            var q=10
            this.myexpense.subcatactive(this.editedSubCategory,q).subscribe()
            this.refreshList();  

          }
          updatesubcat(){
             var q=11
            this.myexpense.updatesubcat(this.editedSubCategory,q).subscribe()
            this.refreshList();

          }
          updatecat(){
            var q=12
            this.myTable = false;
           this.myexpense.updatecat(this.editedProduct,q).subscribe(
               res=>{
         
                swal(res)
           
                this.refreshList1();
              }
           )
         

         }
  selectacc() {
       
      }
  selectName(){

       
      }
  selectcat(){

      
      }
  addcategory(){
        debugger;
        var q=4
        this.myTable = false;
        if(this.accountid != null && this.type!= null && this.catname !=null ){
      this.myexpense.getAddcat(this.accountid,this.type,this.catname,this.uid,q).subscribe(
        res=>{
         
          swal(res)
     
          this.refreshList1();
          this.accountid =null
          this.type = null
          this.catname=null
          this.accountid =''
          this.type = ''
          this.catname=''
       
        }



      )
  } else{

    swal('Please fill all fields');
    this.refreshList1();
    this.accountid =null
    this.type = null
    this.catname=null
    this.accountid =''
    this.type = ''
    this.catname=''

  }
     

      }
  addsubcategory(){
        debugger;
        var q=6
        this.myTable = false;
        if(this.subcatnamebycat !=null && this.subcatdefaultamount !=null ){
      this.myexpense.AddSubcatByCat(this.editedProduct,this.subcatnamebycat,this.subcatdefaultamount,q).subscribe(
        res=>{
         
          swal(res)
          this.myTable = true;
          this.refreshList();
          this.subcatnamebycat =null
          this.subcatdefaultamount = null
         
          this.subcatnamebycat =''
          this.subcatdefaultamount = ''
          
        }

      )
      }else{
swal('please enter all fields');
this.refreshList();
this.subcatnamebycat =null
this.subcatdefaultamount = null

this.subcatnamebycat =''
this.subcatdefaultamount = ''

      }
    
      }
      addsubcat(){
        debugger;
        var q=6
        this.mysubTable = false;
        if(this.categoryid !=null&& this.subcatname!= null && this.defaultamount != null ){
      this.myexpense.AddSubcat(this.categoryid,this.subcatname,this.defaultamount,q).subscribe(
        res=>{
         
          swal(res)
          this.mysubTable = true;
          this.refreshList();
          this.categoryid=null;
          this.categoryid='';
          this.subcatname =null
          this.defaultamount = null
         
          this.subcatname =''
          this.defaultamount = ''
          
        }


      )
      this.refreshList1();
      }else{

        this.mysubTable = true;
        this.refreshList();
        this.categoryid=null;
        this.categoryid='';
        this.subcatname =null
        this.defaultamount = null
       
        this.subcatname =''
        this.defaultamount = ''
      }
      }
  getcattype() {  
        debugger;
        //this.myexpense.getAccountList(this.uid).subscribe(
          //data => {
            this.messagetype= this.data;
    
            //console.log(this.nameList);
          /*},
          (err) => {
            this.error = err;
          }
        ); */
      }
      editMember(item: Category) {
        
        console.log(item);
        if(!item) {
          this.productForm = false;
          return;
        }
        
        this.editProductForm = true;
        this.editedProduct = clone(item);
       // this.refreshList();
      }
      editsubcat(item: SubCategory) {
       console.log(item)
        if(!item) {
          this.SubCategoryForm = false;
          return;
        }

        this.editCategoryForm = true;
        this.editedSubCategory = clone(item); 
       // this.refreshList();
      }
         
      
}
