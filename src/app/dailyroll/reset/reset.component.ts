import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { ResetService } from '../../services/reset.service';
@Component({
  selector: 'app-reset',
  templateUrl: './reset.component.html',
  styleUrls: ['./reset.component.css']
})
export class ResetComponent implements OnInit {
  uid:string='';
  oldpass:string;
  newpass : string;
  repass :string;
  success :any;
  error:boolean=false;

  error_message="";
  errorMessage:string="";
  successMessage:string="";
  constructor(private router:Router, private myexpense:ResetService) { }

  ngOnInit() {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
      // console.log(this.uid);
    } 
  }
resetpass(){
  debugger;
  this.myexpense.reset(this.oldpass,this.newpass,this.repass,this.uid).subscribe(
    data =>{
      this.success = data;
    }
  );
  this.oldpass=null;
  this.newpass=null;
  this.repass=null;
}
}
