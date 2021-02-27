
import { Component ,OnInit} from '@angular/core';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { Observable, of  } from 'rxjs';
import { NestedTreeControl } from '@angular/cdk/tree';
import { CategoryService } from '../../services/category.service';
import {clone} from  'lodash'
import { MatTreeNestedDataSource } from '@angular/material/tree/data-source/nested-data-source';
export type  classification={name :string,id:string,symbol:string,currency:string,accname:string,busname:string,showtype:string,subcatname:string,type:string,status:any,amount:string,count:any,children :classification[], newSpecies?:number}

import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import swal from 'sweetalert';
@Component({
  selector: 'app-treeexp',
  templateUrl: './treeexp.component.html',
  styleUrls: ['./treeexp.component.css']
})
export class TreeexpComponent implements OnInit {
uid:any;
resalert:any;
resdata:any;
catshow:boolean=false;
treeControl: NestedTreeControl<classification>;
classifications: classification[];
contactname:any;
contactemail:any;
contactaddress:any;
contactphone:any;
selectaccountid:any;
mycontacts:any;
mytablecontacts:boolean=false;
myTable:boolean=false;
editProductForm: boolean = false;
productForm: boolean = false;
editedProduct: any = {};
editcontactform: boolean = false;
editcontactproduct: any = {};
selecttype:any;
selectname:any;
addname:any;
datares:any;
addaccname:any;
addamount:any;
  constructor(private category:CategoryService,private router:Router) { 
    
    if(sessionStorage.getItem('uid')!= null){
      this.uid = sessionStorage.getItem('uid');
    }
   this.gettree();

  }
 
  ngOnInit(): void {
   

  }
 
 

 gettree(){


 
  debugger;
  this.category.gettree(this.uid).subscribe(
    res => {
      this.resdata=res;
      //this.classification=this.resdata
    
      this.classifications=this.resdata
      this.treeControl= new NestedTreeControl<classification>(node =>  of(node.children))
      this.catshow=true;
      
    },
   
  );
}
getContact(){
  var q=8
  this.mytablecontacts=false
  debugger;

  this.category.gettreeContact(this.selectaccountid,this.selecttype,q).subscribe(
    res => {
      this.mycontacts = res;
     
   this.mytablecontacts=true
    },


  )

    
  }
addcontact(){
  var q=7
  this.myTable = false;
  debugger;
if(this.contactaddress !=null && this.contactemail !=null && this.contactname !=null && this.contactphone !=null){
  this.category.addtreecontact(this.contactname,this.contactemail,this.contactaddress,this.contactphone,this.selectaccountid,this.selecttype,q).subscribe(
    res => {
      this.resalert=res;
      swal(this.resalert);
      this.myTable = true;
   this.contactname=null;
   this.contactname='';
   this.contactaddress=null;
   this.contactaddress='';
   this.contactemail=null;
   this.contactemail='';
   this.contactphone=null;
   this.contactphone='';
    
    },


  )
  }else{


  }
    
  }
editMember(item) {
      console.log(item);
      if(!item) {
        this.productForm = false;
        return;
      }
      
      this.editProductForm = true;
      this.editedProduct = clone(item);
    // this.refreshList();
    this.selectaccountid=this.editedProduct.id;
    this.selecttype=this.editedProduct.type;
    this.selectname=this.editedProduct.name;
  
      this.getContact();
    }
 updatename(){
  var q=9
   debugger;

  this.category.updatename(this.editedProduct,this.selectaccountid,this.selecttype,q).subscribe(
    res => {
    this.datares=res;
    swal(this.datares);
      this.gettree();
    
    },


  )
  }
  updatesubac(){
  var q=12;
   debugger;

  this.category.updatesubacc(this.editedProduct,this.selectaccountid,this.selecttype,q).subscribe(
    res => {
    this.datares=res;
    swal(this.datares);
      this.gettree();
    
    },


  )




  }
viewdata(){
 let navigationExtras: NavigationExtras = {
      queryParams: {
          "account_id":this.selectaccountid
      }
    };
   // this.userservice.alertMsg("hello")

    this.router.navigate(['dailyroll/viewaccount'],navigationExtras);
  }
adddata(){

    var q=10
    debugger;
 
   this.category.addname(this.addname,this.selectaccountid,this.selectname,q).subscribe(
     res => {
     this.datares=res;
     swal(this.datares);
     this.addname="";
     this.addname=null;
       this.gettree();
     
     },
 
 
   )
 

  }
  addbus(){

    var q=15
    debugger;
 
   this.category.addbusname(this.addname,this.uid,q).subscribe(
     res => {
     this.datares=res;
     swal(this.datares);
     this.addname="";
     this.addname=null;
       this.gettree();
     
     },
 
 
   )
 

  }

  addaccdata(){
    var q=11
    debugger;
 
   this.category.addaccname(this.addaccname,this.addamount,this.selectaccountid,this.selectname,q).subscribe(
     res => {
     this.datares=res;
     swal(this.datares);
     this.addaccname="";
     this.addaccname=null;
     this.addamount='';
     this.addamount=null;
       this.gettree();
     
     },
 
 
   )
 


  }

  activate(){

    var q=13;
    debugger;
 
   this.category.updatesubacc(this.editedProduct,this.selectaccountid,this.selecttype,q).subscribe(
     res => {
     this.datares=res;
     swal(this.datares);
       this.gettree();
     
     },
   )

  }
  inactivate(){
    var q=14;
    debugger;
 
   this.category.updatesubacc(this.editedProduct,this.selectaccountid,this.selecttype,q).subscribe(
     res => {
     this.datares=res;
     swal(this.datares);
       this.gettree();
     
     },
 
   )
  }
  viewalldata(){
    let navigationExtras: NavigationExtras = {
      queryParams: {
          "account_id": this.selectaccountid
      }
    }

    this.router.navigate(['dailyroll/alllist'],navigationExtras);

  }
editcontact(item){
  console.log(item);
  if(!item) {
    this.productForm = false;
    return;
  }
  
  this.editcontactform = true;
  this.editcontactproduct = clone(item);

}
updatecontact(){
  this.catshow=false;
  var q=16;
  this.category.updatecontact(this.editcontactproduct,q).subscribe(
    res => {
    this.datares=res;
    swal(this.datares);
      this.gettree();
    this.catshow=true;
    },


  )
   

}
deletecontact(){
  this.catshow=false;
  var q=17;
  this.category.updatecontact(this.editcontactproduct,q).subscribe(
    res => {
    this.datares=res;
    swal(this.datares);
      this.gettree();
    this.catshow=true;
    },


  )
   

}
}

