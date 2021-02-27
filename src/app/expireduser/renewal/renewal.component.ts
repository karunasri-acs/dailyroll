import { AfterViewChecked } from '@angular/core';
import { Component, OnInit , ElementRef } from '@angular/core';
import { Router, ActivatedRoute,NavigationExtras } from '@angular/router';
declare let paypal: any;
import { CategoryService } from '../../services/category.service';
import { ProfileService } from '../../services/profile.service';
@Component({
  selector: 'app-renewal',
  templateUrl: './renewal.component.html',
  styleUrls: ['./renewal.component.css']
})
export class RenewalComponent implements  AfterViewChecked, OnInit {
  catList: any;  
  uid:string='';
  location:any;
  name:any;
  error: any;
  details:any;
  private sub: any;
  catId: Number;  
  orgid: any;
  des :any;
  needtype: any;
  fundlist :any;
  FunId:any;
  amount :any;
  email:any;
  constructor(private router:Router,private myexpense:CategoryService, private profileser:ProfileService, private activatedRoute: ActivatedRoute, private elem:ElementRef){}
 

  ngOnInit() {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = localStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
       this.email= sessionStorage.getItem('email');
       this.amount='3.99';
  }
  this.getprofiles();
}
getprofiles(){
  this.profileser.getDetails(this.uid).subscribe(data=>{
    this.details = data;
   // this.userservice.alertMsg(data)
  });
}
  addScript: boolean = false;
  paypalLoad: boolean = true;
  finalAmount: number = 5;
  paypalConfig = {
    env: 'sandbox',
    client: {
      sandbox: 'ARnY6ALjQgUvySoBshDMM0wurCnqMzLYNfq13FU8mxtetSe5gV1vJgF5rsXD9jlDQk3YaB4zCw8YfeqM',
      production: '<your-production-key here>'
    },
    commit: true,
    payment: (data, actions) => {
      return actions.payment.create({
        payment: {
          transactions: [
           
            { amount: { total: '3.99', currency: 'USD' } }
          ]
        }
      });
    },
    onAuthorize: (data, actions) => {
      return actions.payment.execute().then((payment) => {
        this.myexpense.insertFund(this.uid).subscribe();
       
       let navigationExtras: NavigationExtras = {
          queryParams: {
       
          }
        };

        this.router.navigate(['dailyroll/myexpense'],navigationExtras);
        
      })
    }
  };

  ngAfterViewChecked(): void {
    if (!this.addScript) {
      this.addPaypalScript().then(() => {
        paypal.Button.render(this.paypalConfig, '#paypal-checkout-btn');
        this.paypalLoad = false;
      })
    }
  }
  
  addPaypalScript() {
    this.addScript = true;
    return new Promise((resolve, reject) => {
      let scripttagElement = document.createElement('script');    
      scripttagElement.src = 'https://www.paypalobjects.com/api/checkout.js';
      scripttagElement.onload = resolve;
      document.body.appendChild(scripttagElement);
    })
  }

}
