import { Component, OnInit, ViewChild, ElementRef} from '@angular/core';
import { Router, ActivatedRoute } from '@angular/router';
import swal from 'sweetalert';
import { RegisterServiceService } from '../../services/register-service.service';
import { ENCRYPTSERVICE } from '../../services/encrypt.service';

@Component({
  selector: 'app-dashboard',
  templateUrl: 'register.component.html',
  providers:[RegisterServiceService]
})
export class RegisterComponent implements OnInit {
  constructor(private router:Router, private registerservice:RegisterServiceService,private encryptservice:ENCRYPTSERVICE){}
  firstname :any;
  email :any;
  password :any;
  phone :any;
  encryptfirstname :any;
  encryptemail :any;
  encryptphone :any;
  results:any;
  captchacheck:any;  
  disabledsignin: boolean = true;  
  showsignin : boolean = false;
  googlekey:any;
  encryptdata:any;
  @ViewChild('recaptcha', {static: true }) recaptchaElement: ElementRef; 
  ngOnInit(){
    this.googlekey=sessionStorage.getItem('key')
    //this.userservice.alertMsg(this.googlekey);
    this.addRecaptchaScript();
  }
  renderReCaptch() {
    window['grecaptcha'].render(this.recaptchaElement.nativeElement, {
      'sitekey' : sessionStorage.getItem('key'),
      'callback': (response) => {
          console.log(response);
          this.captchacheck='checked';
          this.showsignin=true;
          this.disabledsignin=false;

      }
    });
  }
 
  addRecaptchaScript() {
 
    window['grecaptchaCallback'] = () => {
      this.renderReCaptch();
    }
 
    (function(d, s, id, obj){
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) { obj.renderReCaptch(); return;}
      js = d.createElement(s); js.id = id;
      js.src = "https://www.google.com/recaptcha/api.js?onload=grecaptchaCallback&amp;render=explicit";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'recaptcha-jssdk', this));
 
  }
  createUser(){
  debugger;
     if(this.firstname !=null && this.email !=null && this.password !=null && this.phone !=null ){
      this.nameencrypt();
      this.emailencrypt();
      setTimeout(()=>{    
    if(this.encryptfirstname !=null && this.encryptemail !=null && this.password !=null && this.encryptphone !=null ){
      this.registerservice.createUser(this.encryptfirstname,this.encryptemail,this.password,this.encryptphone)
              .subscribe(
                res=> {
                  setTimeout(() => {  
                    debugger;
                  
                    swal(res);
                
                    
                    this.router.navigate(['/login']);
                  
              
                    
                    
                  }, 2000);
                
                  } );
      // this.router.navigateByUrl['/dashboard']
      }
      else {
        swal({
          title: "Sorry?",
          text: "Please Enter all details to Register",
          icon: "warning",
          dangerMode: true,
        });
      }
    }, 6000)
    }
    else {
      swal({
        title: "Sorry?",
        text: "Please Enter all details to Register",
        icon: "warning",
        dangerMode: true,
      });
    }
  } 
  nameencrypt(){
 
   
    this.registerservice.encryptregdata(this.firstname,this.phone).subscribe(
     res=>{
        this.encryptdata=res;
        for (let key of this.encryptdata) {
          if(key.firstname != null){
           this.encryptfirstname=key.firstname;
           
          }
         
         if(key.phone !=null){
          this.encryptphone=key.phone;
         }
        }
   
    })
  }
 
  emailencrypt(){
    
   
    this.encryptservice.encryptdata(this.email).subscribe(
      res=>{
         this.encryptemail=res;
         
    
     })

  }
}
