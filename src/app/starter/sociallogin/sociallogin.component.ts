import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import { LoginServiceService } from '../../services/login-service.service';
import { UserServiceService } from '../../services/user-service.service';
import { User } from '../user';
@Component({
  selector: 'app-sociallogin',
  templateUrl: './sociallogin.component.html',
  styleUrls: ['./sociallogin.component.css']
})
export class SocialloginComponent implements OnInit {
  groupid:any;
  sub:any;
  users:any;
  uid:any;
  userid:any;
  email:any;
  name:any;
  photo:any;
  usertype:any;
  constructor(private userservice:UserServiceService,private router:Router,private activatedRoute: ActivatedRoute,private loginService:LoginServiceService) { }

  ngOnInit(): void {

    this.sub = this.activatedRoute.queryParams.subscribe(params => {
      this.groupid = params["uid"];

     });
     this.getuserdetails();


  }
  getuserdetails(){
    this.loginService.getuserdetails(this.groupid)      
    .subscribe(
        (res: User[]) => {
          // Update the list of carste
          this.users = res;
          console.log(this.users);
          for (let key of this.users) {
          console.log("object:", key);
          this.uid = key.uid;
          this.email = key.email;
          this.name = key.name;
          this.photo = key.photo;
          this.usertype=key.usertype;
         this.userid=key.userid;

            }
        
            sessionStorage.setItem('uid',this.uid);
              sessionStorage.setItem('userid',this.userid);
              sessionStorage.setItem('email',this.email);
              sessionStorage.setItem('name',this.name);
              sessionStorage.setItem('photo',this.photo);
              sessionStorage.setItem('usertype',this.usertype);
              sessionStorage.setItem('photo',this.photo);

              if(this.usertype == 'expireduser'){
                this.router.navigate(['/expireduser/renewel']);
              }
              else if(this.usertype =='validuser'){
                this.router.navigate(['/dailyroll']);
              }

        },
       
      );

  }
}
