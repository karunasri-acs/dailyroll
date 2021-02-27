import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import { AccountService } from '../../services/account.service';
@Component({

  selector: 'app-alllist',
  templateUrl: './alllist.component.html',
  styleUrls: ['./alllist.component.css']
})
export class AlllistComponent implements OnInit {
  private sub: any;
  account_id:any;
  uid:any;
  expensesaccount:any;
  error:any;
  incomeaccount:any;
  myTable:boolean = false;
  myTab:boolean = false;
  constructor(private router:Router,private activatedRoute: ActivatedRoute, private accountservice:AccountService) { }

      ngOnInit() {
        this.uid = sessionStorage.getItem('uid');
        this.sub = this.activatedRoute.queryParams.subscribe(params => {
          debugger;
          this.account_id = params["account_id"];

          });
        this.getexpenses();
        this.getincome();
      }

    getexpenses(){

      var q=1
      debugger;
      this.myTable = false;
      this.accountservice.getexpensesacc(this.account_id,q).subscribe(
        res => {
          this.expensesaccount = res;
          // this.userservice.alertMsg(this.expensesaccount);
        //  this.dtTrigger.next();
        this.myTable = true;
        console.log(this.expensesaccount);
        },
        (err) => {
          this.error = err;
        }
      );

    }
    getincome(){

      var q=2
      debugger;
      this.myTab = false;
      this.accountservice.getincomeacc(this.account_id,q).subscribe(
        res => {
          this.incomeaccount = res;
        //  this.dtTrigger.next();
        this.myTab = true;
        console.log(this.incomeaccount);
        },
        (err) => {
          this.error = err;
        }
      );


    }
  }

 
