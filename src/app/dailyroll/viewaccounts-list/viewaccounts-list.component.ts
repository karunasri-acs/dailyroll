import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, NavigationExtras } from '@angular/router';
import { AccountService } from '../../services/account.service';
import { Subject } from 'rxjs';
@Component({
  selector: 'app-viewaccounts-list',
  templateUrl: './viewaccounts-list.component.html',
  styleUrls: ['./viewaccounts-list.component.css']
})
export class ViewaccountsListComponent implements OnInit {
  private sub: any;
  accountlist : any;
  myTable:boolean=false
  error : any;
  name: string;
  email :string;
  password :string;
  uid:string='';
  account_id: Number;
  member_id:Number;
  //dtOptions: DataTables.Settings = {};
  //dtTrigger: Subject<any> = new Subject();
  constructor(private router:Router,private activatedRoute: ActivatedRoute, private accountservice:AccountService) { }

  ngOnInit() {
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
    this.sub = this.activatedRoute.queryParams.subscribe(params => {
      debugger;
      this.account_id = params["account_id"];
      this.member_id = params["member_id"];

  });
 // this.userservice.alertMsg(this.account_id);
  this.getList();
  }
  getList() {
    var q=3
        debugger;
        this.accountservice.viewAccountList(this.account_id,this.member_id,q).subscribe(
          res => {
            this.accountlist = res;
          //  this.dtTrigger.next();
          //  console.log(this.expenses);
          this.myTable = true;
          },
          (err) => {
            this.error = err;
          }
        );
      }
  
  /* getGroupList(accountid){
    debugger;
    this.accountservice.getMemberList(String(accountid)).subscribe(
      res => this.groupList
    );

   }
   
   getGroupList() {

    debugger;
    this.accountservice.getMemberList(String(this.account_id)).subscribe(
      res => {
        this.groupList = res;
        this.dtTrigger.next();
      //  console.log(this.expenses);
      },
      (err) => {
        this.error = err;
      }
    );
  }
   private refreshList(){
   // this.getGroupList();
   }
  */
}
