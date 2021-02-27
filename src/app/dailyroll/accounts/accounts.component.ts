import { Component, OnInit ,ElementRef} from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import 'rxjs/add/operator/map';
import swal from 'sweetalert';
import { AccountService } from '../../services/account.service';
import { Accounts } from './account';
import { Subject } from 'rxjs';
import {clone} from  'lodash';

@Component({
  selector: 'app-accounts',
  templateUrl: './accounts.component.html',
  styleUrls: ['./accounts.component.css'],
  providers:[AccountService]
})
export class AccountsComponent implements OnInit {
  accountlist:any;
  mycontacts:any;
  unarchivelist:any;
  uid:string='';
  editProductForm: boolean = false;
  productForm: boolean = false;
  editedProduct: any = {};
  error: any;
  accountname:any;
  grouplist : any;
  myTable:boolean = false;
  mytablecontacts:boolean = false;
  myacraved:boolean = false;
  archieveacclist:any;
  dtOptions: DataTables.Settings = {};
  dtTrigger: Subject<any> = new Subject();
  dtOptions1: DataTables.Settings = {};
  dtTrigger1: Subject<any> = new Subject();
  subcatnamebycat:any;
  results: any;
  data:any;
  currencyid: any;
  currencylist: any;
  contactname:any;
  contactemail:any;
  contactaddress:any;
  contactphone:any;
  selectaccountid:any;
  constructor(private router:Router, private accountservice:AccountService, private elem:ElementRef) { }

  ngOnInit() {
    $(function () {
      $('#example').DataTable( {
        
    } );
  });
    
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
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
    this.getList();
    this.getCurrency();
    this.getUnarchiveList();
    this.getArchieveList();
  }
  getCurrency() {
    debugger;
    this.currencylist= this.data;
  }
  selectName(){
 // this.userservice.alertMsg(this.currencyid);
       
  }
  getList() {
    var q=1
    debugger;
    this.myTable = false;
    this.accountservice.getAccounts(this.uid,q).subscribe(
      res => {
        this.accountlist = res;
        this.myTable = true;
       console.log(this.accountlist);
      },
      (err) => {
        this.error = err;
      }
    );
  }
  getArchieveList() {
      debugger;
      var q=13;
      this.myacraved = false;
      this.accountservice.getArchieveAccounts(this.uid,q).subscribe(
          res => {
            this.archieveacclist = res;
            this.myacraved = true;
            console.log(this.archieveacclist);
          },
          (err) => {
            this.error = err;
          }
        );
      }
  getContact(){
      var q=2
      this.myTable = false;
      debugger;
    
      this.accountservice.getContact(this.selectaccountid,q).subscribe(
        res => {
          this.mycontacts = res;
        this.myTable=true;
        this.mytablecontacts=true
        },
  
  
      )

        
      }
  addcontact(){
      var q=1
      this.myTable = false;
      debugger;
    
      this.accountservice.addcontact(this.contactname,this.contactemail,this.contactaddress,this.contactphone,this.selectaccountid,q).subscribe(
        res => {
          this.myTable = true;
        swal(res);
        this.refreshList();
        },
  
  
      )

        
      }
  addaccount(){
    var q=4
    this.myTable = false;
    debugger;
    this.accountservice.getAddAccounts(this.accountname,this.currencyid,this.uid,q).subscribe(
      res => {
        this.myTable = true;
     swal(res);
     this.refreshList();
      },


    )
    

  }
 
  getUnarchiveList(){
      this.accountservice.getUnarchiveList(this.uid).subscribe(
      res => {
        this.unarchivelist = res;
      //  this.dtTrigger1.next();
      //  console.log(this.expenses);
      },
      (err) => {
        this.error = err;
      }
    );
  }
 
  public AddAccount():void{
  
      debugger;
      this.accountservice.saveAccount(this.uid,this.accountname).subscribe(
      res=>{
        this.results =res
        swal(res)
        this.refreshList();
        this.refreshList1();
      }
    );
    }
    private refreshList(){
     this.getList();
    }
    private refreshList1(){
      this.getArchieveList();
     }
    editMember(item: Accounts) {
    
    if(!item) {
     
      this.productForm = false;
      return;
    }
    console.log(item);
    this.editProductForm = true;
    this.editedProduct = clone(item);
    this.selectaccountid=this.editedProduct.account_id;
 this.getContact();
  }

  updateProduct() {
      this.accountservice.updateProd(this.editedProduct).subscribe(
        res=>{
          this.results =res
          swal(res)
          this.refreshList();
          this.refreshList1();
        }
      );
    }

    removeProduct(){
      this.accountservice.archiveaccount(this.editedProduct).subscribe(
        res=>{
          this.results =res
          swal(res)
          this.refreshList();
          this.refreshList1();
        }
      );
      
    }
    UnArchive(selectedItem: any){
      let id = selectedItem.account_id;
      this.accountservice.unarchive(id).subscribe(
        res=>{

          this.results =res
          swal(res)
        }   
      );

    }
    inactivate(){
      var q= 10;
      this.accountservice.inactiveacc(this.editedProduct,this.uid,q).subscribe(
        res=>{
          this.results =res
          swal(res)
          this.refreshList();
          this.refreshList1();
        }

      )
    }
    activate(){
      var q= 11;
      this.accountservice.activeacc(this.editedProduct,this.uid,q).subscribe(
        res=>{
          this.results =res
          swal(res)
          this.refreshList();
          this.refreshList1();
        }

      )


    }
  viewAccount(selectedItem: any) {
   // this.userservice.alertMsg("1234")
      console.log("Selected item Id: ", selectedItem.account_id); // You get the Id of the selected item here
  
      let navigationExtras: NavigationExtras = {
        queryParams: {
            "account_id": selectedItem.account_id
        }
      };
     // this.userservice.alertMsg("hello")

      this.router.navigate(['dailyroll/viewaccount'],navigationExtras);
  }
  viewlistaccounts(selectedItem: any) {
    console.log("Selected item Id: ", selectedItem.account_id); // You get the Id of the selected item here
    //this.userservice.alertMsg(selectedItem.account_id);
   // this.router.navigate(['/viewaccounts']
    let navigationExtras: NavigationExtras = {
      queryParams: {
          "account_id": selectedItem.account_id
      }
    }

    this.router.navigate(['dailyroll/alllist'],navigationExtras);
  }
}
