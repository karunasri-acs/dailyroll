import { Component, OnInit } from '@angular/core';
import { DashboardService } from '../../services/dashboard.service';
import { Router } from '@angular/router';
import { Observable, of  } from 'rxjs';
import { NestedTreeControl } from '@angular/cdk/tree';

import { MatTreeNestedDataSource } from '@angular/material/tree/data-source/nested-data-source';
import { delay } from 'rxjs/operators';
export type  classification={name :string,id:string,type:string,amount:string,filepath:string,children :classification[], newSpecies?:number}





@Component({
  selector: 'app-newexpenses',
  templateUrl: './newexpenses.component.html',
  styleUrls: ['./newexpenses.component.css']
})
export class NewexpensesComponent implements OnInit {
  uid:any;
  accountslist:any;
  accountid:any;
  dropstatus:any;
  dd:any;
  penstatus:any;
  yeardrop:any;
  selectyear:any;
  treeControl: NestedTreeControl<classification>;
  classifications: classification[];
  resdata:any;
  catshow:boolean=false;
  constructor(private router:Router, private count:DashboardService) {
    if(sessionStorage.getItem('uid')!= null){ 
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
      this.getAccounts();
      this.dropdown();
     
     
     
   }

  ngOnInit(): void {
   
  }
  dropdown(){
    this.dd=this.dropstatus
    for(let item of this.dd){
      var prod = item.status

    }
    this.penstatus =prod;
    }
  getAccounts() {
    var q=1
        debugger;
       
        this.count.getAccountsList(this.uid,q).subscribe(
          res => {
            this.accountslist = res;
            for(let item of this.accountslist){
              var aid = item.account_id

            }
           
            this.accountid =aid;
            if(this.accountid !=''){
              this.getyear();
            }
           // this.userservice.alertMsg(this.accountid);
            alert(this.accountid);
            console.log(this.accountslist)
           },
         
        );
 }
 searchAccount(){

 }
 selectpenstatus(){


 }
 getyear(){
  var q=1
  debugger;
 
  this.count.getyear(this.uid,q).subscribe(
    res => {
      this.yeardrop = res;
      for(let item of this.yeardrop){
        var year = item.year

      }
     
      this.selectyear =year;
      alert(this.selectyear);
      if(this.selectyear !=''){
        this.searchtree();
      }
     // this.userservice.alertMsg(this.accountid);
      
      console.log(this.selectyear)
     },
   
  );


 }
 searchtree(){
  var q=2
  debugger;
  this.catshow=false;
  
  this.count.getexpensestree(this.accountid,this.penstatus,this.selectyear,q).subscribe(
    res => {
      this.resdata=res;
      //this.classification=this.resdata
   
      this.classifications=this.resdata
      this.treeControl= new NestedTreeControl<classification>(node =>  of(node.children))
      this.catshow=true;
     
     },
   
  );


 }



}

