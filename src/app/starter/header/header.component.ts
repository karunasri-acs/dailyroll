import { Component, OnInit } from '@angular/core';
import { UserServiceService } from '../../services/user-service.service';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
furl:any;
newsList: any;
uid: number;
  constructor(private userservice:UserServiceService) {
    var t = window.location.href;
    //var t = 'https://apps.dinkhoo.com/ANG/elitecap/member/#/login';
     var tt = t.substr(0, t.lastIndexOf('/member'));
     
     this.furl = tt; 

   }

   ngOnInit() {
    this.getAuth();
    this.getKey();
  }

  getAuth(){
    this.uid=1;
    var q=1
    this.userservice.getAuthCode(this.uid,q).subscribe(
      res => {
        this.newsList = res;
        //this.userservice.alertMsg(this.newsList);
        sessionStorage.setItem('authcode',this.newsList);
  
       }
    );  
  }
  getKey(){
    debugger;
    this.uid=1;
    var q=2
    this.userservice.getgooglekey(this.uid,q).subscribe(
      res => {
        this.newsList = res;
       // this.userservice.alertMsg(this.newsList);
        sessionStorage.setItem('key',this.newsList);
      
       }
    );  
  }

}
