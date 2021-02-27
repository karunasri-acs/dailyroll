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
  unarchivelist:any;
  uid:string='';
  editProductForm: boolean = false;
  productForm: boolean = false;
  editedProduct: any = {};
  error: any;
  accountname:any;
  grouplist : any;
  myTable:boolean = false;
  myacraved:boolean = false;
  archieveacclist:any;
dtOptions: DataTables.Settings = {};
  dtTrigger: Subject<any> = new Subject();
  dtOptions1: DataTables.Settings = {};
  dtTrigger1: Subject<any> = new Subject();
  subcatnamebycat:any;
  results: any;
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
    this.getList();
    this.getUnarchiveList();
    this.getArchieveList();
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

      console.log("Selected item Id: ", selectedItem.account_id); // You get the Id of the selected item here
      //this.userservice.alertMsg(selectedItem.account_id);
     // this.router.navigate(['/viewaccounts']
   //  this.userservice.alertMsg(selectedItem.account_id);
      let navigationExtras: NavigationExtras = {
        queryParams: {
            "account_id": selectedItem.account_id
        }
      };

      this.router.navigate(['expireduser/viewaccount'],navigationExtras);
  }
  viewlistaccounts(selectedItem: any) {
    console.log("Selected item Id: ", selectedItem.account_id); // You get the Id of the selected item here
    //this.userservice.alertMsg(selectedItem.account_id);
   // this.router.navigate(['/viewaccounts']
    let navigationExtras: NavigationExtras = {
      queryParams: {
          "account_id": selectedItem.account_id
      }
    };

    this.router.navigate(['dailyroll/alllist'],navigationExtras);
}
}
 
  