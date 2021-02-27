import { Component ,OnInit} from '@angular/core';
import { BreakpointObserver, Breakpoints } from '@angular/cdk/layout';
import { Observable, of  } from 'rxjs';
import { NestedTreeControl } from '@angular/cdk/tree';
import { CategoryService } from '../../services/category.service';
import {clone} from  'lodash'
import { MatTreeNestedDataSource } from '@angular/material/tree/data-source/nested-data-source';
export type  classification={name :string,id:string,type:string,status:any,amount:string,children :classification[], newSpecies?:number}
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import swal from 'sweetalert';
@Component({
  selector: 'app-treeexp',
  templateUrl: './treeexp.component.html',
  styleUrls: ['./treeexp.component.css']
})
export class TreeexpComponent implements OnInit {
uid:any;
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
   // alert(this.selecttype);
      this.getContact();
    }
 }

