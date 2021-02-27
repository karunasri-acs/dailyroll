import { Component , OnInit} from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import { LoginServiceService } from '../../services/login-service.service';
import { User } from '../user';
import 'rxjs/add/operator/map';
import { MyexpenseService } from '../../services/myexpense.service';
import {DomSanitizer,SafeResourceUrl} from '@angular/platform-browser';
import swal from 'sweetalert';
import { ENCRYPTSERVICE } from '../../services/encrypt.service';
@Component({
  selector: 'app-dashboard',
  templateUrl: 'login.component.html',
  providers:[LoginServiceService]
})
export class LoginComponent implements OnInit {
  //users: Object;
  error:boolean=false;
 
  error_message="";
  users:any;
  authcode: string = "";
  success = '';
  uid: string;
  userid:any;
  email: string;
  usertype:string;
  name:string;
  devicecode:any;
  qrcodeurl:any;
  photo:any;
  getCode:any;
  auth: any;
  myTable:boolean=false;
  myform:boolean=true;
  mybutton:boolean=false;
  public user: User = new User();
furl:any;
auth_code:any;
 // email:string;
   people = [{"uid":"5bde07fdbf7ad1.43644827","name":"kaniketi","email":"kuru@gmail.com"}]
   heroes = ['Windstorm', 'Bombasto', 'Magneta', 'Tornado'];
  encryptemail: any;
  decryptuid: any;
  decryptedname: any;
  decryptedemail: any;
  constructor(private router:Router,private encryptservice:ENCRYPTSERVICE, private sanitizer: DomSanitizer,private loginService:LoginServiceService){
    var t = window.location.href;
    //var t = 'https://apps.dinkhoo.com/ANG/dailyroll/member/#/login';
    var tt = t.substr(0, t.lastIndexOf('/member'));
    this.furl = tt; 
  }
  public username;
  public password;
  urlif:any;
  urlif1:any;
  ngOnInit() {
    this.urlif= this.sanitizer.bypassSecurityTrustResourceUrl('https://www.dailyroll.org/dailyroll-api/apptour.php')
    if(sessionStorage.getItem('authcode')!= null){
      this.auth_code = sessionStorage.getItem('authcode');
     // this.userservice.alertMsg(this.auth_code); 
      //this.userservice.alertMsg('login page')  
   }
   this.urlif1= this.sanitizer.bypassSecurityTrustResourceUrl('https://dailyroll.org/hybridauth/sociallogin.php')

  }
 ValidateUser(){
     debugger;
    // this.emailencrypt(this.username);
    
    this.loginService.ValidateUser(this.username,this.password)      
    .subscribe(
        (res: User[]) => {
          // Update the list of cars
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
            console.log(this.email);
            }
          this.success = 'Created successfully';
          if(this.auth_code === "YES"){
            //this.userservice.alertMsg("Auth is Yes")
              this.myform = false; 
              this.mybutton=true;
              this.getAuthDetails();
            }
            else{

             
            
             
             
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
           
            }
         
         },
        error=>{
          this.error=!this.error;
          this.error_message="Your Credentials Do not Match";
          console.log(this.error_message);
        }
      );
    
      // this.router.navigateByUrl['/dashboard']
  
    }
    emailencrypt(data:any){
      var inputstring=data
      this.encryptservice.encryptdata(inputstring).subscribe(
       res=>{
          this.encryptemail=res;
         // alert(this.encryptemail)
      })
    }
    getAuthDetails() {
      var q = 1;
     // this.userservice.alertMsg("nandini")
      this.loginService.getAuth(this.userid,q).subscribe(
        res=>{
          this.devicecode = res
          for (let key of this.devicecode) {
            console.log("object:", key);
           // this.userservice.alertMsg("naina")
              this.qrcodeurl = key.qrcode;
             // this.userservice.alertMsg(this.qrcodeurl)
          }
          if(this.qrcodeurl){ 
            //this.userservice.alertMsg(this.userid);
          
            this.myTable = true;

          }
        }
      );
  
    }
  confirm(){
    var q = 2;
    this.loginService.verifyCode(this.authcode,this.userid,q).subscribe(
      res=>{
        this.getCode = res
       
          for (let key of this.getCode) {
            console.log("object:", key);
              
              this.auth = key.code;
          }
         
          //sessionStorage.setItem('authcode',this.auth)
         
          sessionStorage.setItem('uid',this.uid);
          sessionStorage.setItem('userid',this.userid);
          sessionStorage.setItem('email',this.email);
          sessionStorage.setItem('name',this.name);
          sessionStorage.setItem('photo',this.photo);
          sessionStorage.setItem('usertype',this.usertype);
          sessionStorage.setItem('photo',this.photo);
          if(this.auth =='failed'){
            swal({
              title: "Sorry?",
              text: "Please check entered code",
              icon: "warning",
              dangerMode: true,
            });
           }else {
           // this.userservice.alertMsg("usertype");
              if(res){
             // this.userservice.alertMsg(this.usertype)
              if(this.usertype == 'expireduser'){
                this.router.navigate(['/expireduser/renewel']);
              }
              else if(this.usertype =='validuser'){
                this.router.navigate(['/dailyroll']);
              }
       }

      }
     
      }
    )
  
  }
  
  sendrequest(){
    var q =3 
    this.loginService.sendrequest(this.username,q).subscribe(
      res=>{
        swal(res);
        this.myTable = false;
        this.myform = true; 
        this.mybutton=false;
      })
  }
  emaildecrypt(data:any){
  
    var inputstring=data
   // alert(inputstring)
    this.encryptservice.decryptdata(inputstring).subscribe(
     res=>{
        this.decryptedemail=res;
       
       
    })
  }
  namedecrypt(data:any){
  
    var inputstring=data
    //alert(inputstring)
    this.encryptservice.decryptdata(inputstring).subscribe(
     res=>{
        this.decryptedname=res;
    })
  }
}
