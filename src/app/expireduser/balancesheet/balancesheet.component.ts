import { Component, OnInit } from '@angular/core';
import { GroupreportService } from '../../services/groupreport.service';
import { Router, ActivatedRoute } from '@angular/router';
import { Subject } from 'rxjs';

import swal from 'sweetalert';
declare const $;
@Component({
  selector: 'app-balancesheet',
  templateUrl: './balancesheet.component.html',
  styleUrls: ['./balancesheet.component.css']
})
export class BalancesheetComponent implements OnInit {
  status:any;
  searchResult:boolean = false
  nameList :any;  
  nameId: Number;
  currency:any;
  reportList :any;  
  memberList :any;
  rtype: string; 
  type:any;
  memid:any;
  accountslist:any;
  //accountlist:[];
  categorylist:any;
  totalexpensesamount:any;
  totalincomeamount:any;
  catList: any;  
  catId: Number;
  catid:any;  
  uid:string='';
  accountid: string='';
  messagetype:any;
  error: any;
  data: any;
  memberlist:any;
  fromdate:any;
  todate:any;
  subcatid:any;
  subcategorylist:any;  
  groupreports:any;
  dtOptions: DataTables.Settings = {};
  dtTrigger: Subject<any> = new Subject();
  mybutton:boolean=false;
  dropstatus:any;
  calculatesum:any;
  constructor(private router:Router, private myexpense:GroupreportService) { }


  ngOnInit() {
   
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
    
    this.data=[
      {
      "catname":"UntillToday"
      },
      {
        "catname":"CurrentMonth"
      },
      {
        "catname":"CurrentYear"
      }
    
      ] 
      this.dropstatus=[
        {
        "status":"All"
        },
        {
        "status":"non-pending"
        },
        {
          "status":"pending"
        }
      
        ] 
    this.getAccounts();
    this.getReport();
   this.getcattype();
  }
  getcattype() {  
    debugger;
   
        this.messagetype= this.data;

  }
 
  
  getAccounts() {
    var q=1
        debugger;
        this.myexpense.getAccountsList(this.uid,q).subscribe(
          res => {
            this.accountslist = res;
            console.log(this.accountslist)
           },
          (err) => {
            this.error = err;
          }
        );
      }

  getReport() {  
    debugger;
    
     this.reportList=this.data;
  } 
  search(){
    debugger;
    this.mybutton=false;
    if(this.accountid != null && this.type !=null && this.status !=null){
   this.myexpense.getSearchbalData(this.type,this.accountid,this.status)
    .subscribe(  
       res => {
      this.groupreports = res;
      //this.userservice.alertMsg(this.groupreports);
      setTimeout( function(){
     
        $(function () {
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          
        } );
      
        });
       
      },2000)
     
    this.mybutton=true;
    for(let item of this.groupreports){
      var eid = item.totalexpenseamount
      var iid = item.totalincomeamount
      var currency=item.curr
      var calsum=item.calculatesum
    }
   
    this.totalexpensesamount =eid;
   
    this.totalincomeamount =iid;
    this.currency=currency;
    this.calculatesum=calsum;
    this.searchResult = true
    
      console.log(this.groupreports);
    },
    (err) => {
      this.error = err;
    }
  );
   
    }else{


swal('Please select all fields');
  }
}
  
  selectacc(){

  }
  selectName(){
  }

}
