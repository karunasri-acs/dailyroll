import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';

@Component({
  selector: 'app-header',
  templateUrl: './header.component.html',
  styleUrls: ['./header.component.css']
})
export class HeaderComponent implements OnInit {
  uid: string='';
  email: string='';
  usertype: string='';
  imagepath :any;
  constructor(private router:Router) { }

  ngOnInit() {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = localStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
      // this.userservice.alertMsg(this.uid);
      // console.log(this.uid);
     }
     this.email= sessionStorage.getItem('name');
     this.usertype= sessionStorage.getItem('usertype');
    this.imagepath = sessionStorage.getItem("photo");
    console.log(this.imagepath);
  }
  logout(){
    sessionStorage.clear();
    //localStorage.removeItem('name');
    this.router.navigate(['/login']);
  }
}