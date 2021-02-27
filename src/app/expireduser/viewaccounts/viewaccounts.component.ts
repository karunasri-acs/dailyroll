import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import { AccountService } from '../../services/account.service';
import swal from 'sweetalert';
import {clone} from  'lodash'
import { MemberDetails } from './memberdetails';
@Component({
  selector: 'app-viewaccounts',
  templateUrl: './viewaccounts.component.html',
  styleUrls: ['./viewaccounts.component.css']
})
export class ViewaccountsComponent implements OnInit {
  private sub: any;
  userdata:any;
  usertypelist:any;
  viewaccount : any;
  usertype:any;
  error : any;
  name: string;
  email :string;
  password :string;
  uid:string='';
  account_id: Number;
  list:any;
  accountname:any;
  memberemail:any;
  membername:any;
  memberphoneno:any;

  myacraved:boolean = false;
  editProductForm: boolean = false;
  productForm: boolean = false;
  editedProduct: any = {};
 
  data:any;
  currcode: any;
  currencylist: any;
  //dtOptions: DataTables.Settings = {};
  //dtTrigger: Subject<any> = new Subject();
  constructor(private router:Router,private activatedRoute: ActivatedRoute, private accountservice:AccountService) { }

  ngOnInit() {
    if(sessionStorage.getItem('uid') == null){
      // this.email = sessionStorage.getItem('username');
      this.router.navigate(['/login']);
     
    }
    else{
      this.uid = sessionStorage.getItem('uid');
      console.log(this.uid);
    
    }
    this.sub = this.activatedRoute.queryParams.subscribe(params => {
      debugger;
      this.account_id = params["account_id"];

  });
  this.userdata=[
    {
    "usertype":"Read Only"
  
    },
    {
      "usertype":"Write Only"
    
    }

]
  this.data=[
    {
    "currencyname":"Brazilian Real",
    "currencycode":"BRL"
    },
    {
      "currencyname":"Bangladeshi Taka",
      "currencycode":"BDT"
    },
    {
      "currencyname":"Canadian Dollar",
      "currencycode":"CAD"
    },
    {
      "currencyname":"Swiss Franc",
      "currencycode":"CHF"
    },
    {
      "currencyname":"Costa Rican Colon",
      "currencycode":"CRC"
    },
    {
      "currencyname":"Czech Koruna",
      "currencycode":"CZK"
    },
    {
      "currencyname":"Danish Krone",
      "currencycode":"DKK"
    },
    {
      "currencyname":"Euro",
      "currencycode":"EUR"
    },
    {
      "currencyname":"Hong Kong Dollar",
      "currencycode":"HKD"
    },
    {
      "currencyname":"Hungarian Forint",
      "currencycode":"HUF"
    },
    {
      "currencyname":"Israeli New Sheqel",
      "currencycode":"ILS"
    },
    {
      "currencyname":"Indian Rupee",
      "currencycode":"INR"
    },
    {
      "currencyname":"Israeli New Shekel",
      "currencycode":"ILS"
    },
    {
      "currencyname":"JapaneseYen",
      "currencycode":"JPY"
    },
    {
      "currencyname":"Kazakhstan Tenge",
      "currencycode":"KZT"
    },
    {
      "currencyname":"Korean Won",
      "currencycode":"KRW"
    },
    {
      "currencyname":"Cambodia Kampuchean Riel",
      "currencycode":"KHR"
    },
    {
      "currencyname":"Malaysian Ringgit",
      "currencycode":"MYR"
    },
    {
      "currencyname":"Mexican Peso",
      "currencycode":"MXN"
    },
    {
      "currencyname":"Norwegian Krone",
      "currencycode":"NOK"
    },
    {
      "currencyname":"Nigerian Naira",
      "currencycode":"NGN"
    },
    {
      "currencyname":"New Zealand Dollar",
      "currencycode":"NZD"
    },
    {
      "currencyname":"Philippine Peso",
      "currencycode":"PHP"
    },
    {
      "currencyname":"Pakistani Rupees",
      "currencycode":"PKR"
    },
    {
      "currencyname":"Polish Zloty",
      "currencycode":"PLN"
    },
    {
      "currencyname":"Swedish Krona",
      "currencycode":"SEK"
    },
    {
      "currencyname":"Taiwan New Dollar",
      "currencycode":"TWD"
    },
    {
      "currencyname":"Thai Baht",
      "currencycode":"THB"
    },
    {
      "currencyname":"Turkish Lira",
      "currencycode":"TRY"
    },
    {
      "currencyname":"U.S. Dollar",
      "currencycode":"USD"
    },
    {
      "currencyname":"Vietnamese Dong",
      "currencycode":"VND"
    }

] 
this.getCurrency();
    this.getList();
    this. getAccountName();
    this.getusertype();
  }

  getCurrency() {
    debugger;
    this.currencylist= this.data;
  }
  getusertype() {
    debugger;
    this.usertypelist= this.userdata;
  }
  
  inactive(){
   
    var q=8;
    debugger;
   
    this.accountservice.inactive(this.account_id,this.editedProduct,q).subscribe(
      res => {
      
     swal(res);
     this.getList();
      },
    );          
  }

  active(){
 
    var q=12;
    debugger;
  
    this.accountservice.active(this.editedProduct,this.account_id,q).subscribe(
      res => {
  
     swal(res);
     this.getList();
      },
    );          
  }
  admin(){

    var q=9;
    debugger;
    this.myacraved = false;
 this.accountservice.admin(this.editedProduct,this.account_id,q).subscribe(
  res => {
    this.myacraved = true;
 swal(res);
 this.getList();
  },
 );     
  }
  getList() {
 
    var q=2
        debugger;
        this.myacraved = false;
        this.accountservice.viewAccounts(this.account_id,q).subscribe(
          res => {
            this.viewaccount = res;
          //  this.dtTrigger.next();
          this.myacraved = true;
          console.log(this.viewaccount);
          },
          (err) => {
            this.error = err;
          }
        );
      }
      editMember(item: MemberDetails) {
        if(!item) {
         
          this.productForm = false;
          return;
        }
        console.log(item)
        this.editProductForm = true;
        this.editedProduct = clone(item);
             }
      getAccountName() {
        var q=6
            debugger;
            this.accountservice.accountName(this.account_id,this.uid,q).subscribe(
              res => {
                this.accountname = res;
             
              console.log(this.accountname);
              },
              (err) => {
                this.error = err;
              }
            );
          }
          addMemberToGroup() {
            var q=7
                
                debugger;
  
                this.accountservice.addMember(this.account_id,this.memberemail,this.membername,this.memberphoneno,this.usertype,q).subscribe(
                  res => {
              
                 swal(res);
                 this.getList();
                  },
                );
              }
           
      public refreshList(){
        this.getList();
       }
      public update(item:any):void{
        this.list = item;
        swal(this.list.currcode)
       var q=5
       debugger;
     
        this.accountservice.updateAccount(this.list.accountname,this.account_id,this.list.currcode,q).subscribe(
          res => {
           
            swal(res);
            this.getList();
          
          }
        );
       

      }

  viewAccount(item:any){
    let navigationExtras: NavigationExtras = {
      queryParams: {
          "account_id": this.account_id,
          "member_id": item.add_user_id
      }
      };
      this.router.navigate(['/dailyroll/viewaccountlist'],navigationExtras);
  } 
 
    
}