import { Component, OnInit } from '@angular/core';
import { MyincomeService } from '../../services/myincome.service';
import swal from 'sweetalert';
@Component({
  selector: 'app-notifications',
  templateUrl: './notifications.component.html',
  styleUrls: ['./notifications.component.css']
})
export class NotificationsComponent implements OnInit {
  dropstatus:any;
  dtype:any;
  addtype:any;
  seltype:any;
  description:any;
  accountid:any;
  uid:any;
  accountslist:any;
  error:any;
  myTable:boolean = false;
  notlist:any;
  resalert: Object;
  constructor( private myexpense:MyincomeService) { }

  ngOnInit(): void {

    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
    this.dropstatus=[
      {
      "type":"General"
      },
      {
        "type":"Complaint"
      },
      {
        "type":"Contacts"
      }
    
      ] 
      this.gettypedrp();
      this.getAccounts();
      this.getNot();
  }
  gettypedrp(){
    this.dtype=this.dropstatus

  }
  selectacc(){
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
  addNotification(){
var q=1;
this.myTable=false;
    this.myexpense.addNot(this.accountid,this.seltype,this.description,this.uid,q).subscribe(
      res => {
        this.resalert=res;
   
    this.myTable=true;
    swal(this.resalert);
    this.getNot();
       },
      (err) => {
        this.error = err;
      }
    );

this.getNot();    

  }
  getNot(){
    var q=2;
    
    this.myexpense.getNot(this.uid,q).subscribe(
      res => {
  this.notlist=res;
  this.myTable=true;
       },
      (err) => {
        this.error = err;
      }
    );




  }
}
