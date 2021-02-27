import { Component, OnInit,ElementRef } from '@angular/core';
import { MyexpenseService } from '../../services/myexpense.service';
import { Router} from '@angular/router';
import { UserServiceService } from '../../services/user-service.service';
declare var adminLTE: any;

@Component({
  selector: 'app-starter-content',
  templateUrl: './starter-content.component.html',
  styleUrls: ['./starter-content.component.css']
})
export class StarterContentComponent implements OnInit {
email:any;
name:any;
message:any;
data:any;
  constructor(private userservice:UserServiceService,private router:Router, private myexpense:MyexpenseService, private elem:ElementRef) {}

  ngOnInit() {
    // Update the adminLTE layouts
    adminLTE.init();
  }

  addquestion(){
var q=6

this.myexpense.contactus(this.email,this.name,this.message,q).subscribe(
  res => {
    this.data = res;
this.userservice.alertMsg(this.data);
this.email=null;
this.email='';
this.name=null;
this.name='';
this.message=null;
this.message='';
   // this.userservice.alertMsg(this.expenses);
  });



  }
}
