import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-left-side',
  templateUrl: './left-side.component.html',
  styleUrls: ['./left-side.component.css']
})
export class LeftSideComponent implements OnInit {

  uid: string='';
  email: string='';
  imagepath :any;
  constructor() { }

  ngOnInit() {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
       
      // console.log(this.uid);
     }
     this.email= sessionStorage.getItem('name');
     this.imagepath = sessionStorage.getItem("photo");
    console.log(this.imagepath);
  }

}
