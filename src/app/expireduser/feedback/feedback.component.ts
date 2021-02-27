import { Component, OnInit,ElementRef } from '@angular/core';
import { CategoryService } from '../../services/category.service';
import { Router, ActivatedRoute,NavigationExtras } from '@angular/router';
import swal from 'sweetalert';
declare const $;
@Component({
  selector: 'app-feedback',
  templateUrl: './feedback.component.html',
  styleUrls: ['./feedback.component.css']
})
export class FeedbackComponent implements OnInit {
uid:any;
email:any;
accountslist:any;
error:any;
account_id:any;
description:any;
type:any;
constructor(private router:Router, private myexpense:CategoryService, private elem:ElementRef) {
}

  ngOnInit() {
    $('#feedback').on('change',function(){
      if( $(this).val()==="deleterequest"){
      $("#deleterequest").show()
      }
      else{
      $("#deleterequest").hide()
      }
  });
    if(sessionStorage.getItem('uid')!= null){
      // this.email = localStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
       
      // console.log(this.uid);
     }
     this.email= sessionStorage.getItem('email');
     this.getAccounts();
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
selectacc(){

  
}
addFedback(){

  this.myexpense.addFedback(this.email,this.type,this.description).subscribe(
    res => {
      this.accountslist = res;
      swal(this.accountslist);
      this.description==null;
    this.description='';
    this.type=null;
    this.type='';
      console.log(this.accountslist)
     },
    (err) => {
      this.error = err;
    }
  );

}
}
