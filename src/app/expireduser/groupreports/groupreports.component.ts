
import { Component, OnInit } from '@angular/core';
import { GroupreportService } from '../../services/groupreport.service';
import { Router, ActivatedRoute } from '@angular/router';
import { Subject } from 'rxjs';
import swal from 'sweetalert';
declare const $;
@Component({
  selector: 'app-groupreports',
  templateUrl: './groupreports.component.html',
  styleUrls: ['./groupreports.component.css']
})
export class GroupreportsComponent implements OnInit {
  searchResult:boolean = false
  nameList :any;  
  nameId: Number;
  reportList :any;  
  memberList :any;
  rtype: string; 
  type:any;
  memid:any;
  accountslist:any;
  //accountlist:[];
  categorylist:any;
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
  dd:any;
  penstatus:any;
  totalamount:any;
  currencyicons:any;
  constructor(private router:Router, private myexpense:GroupreportService) { }

  ngOnInit() {
    
    if(sessionStorage.getItem('uid')!= null){
      // this.email = sessionStorage.getItem('username');
       this.uid = sessionStorage.getItem('uid');
    }
    
    this.data=[
      {
      "catname":"Expenses"
      },
      {
        "catname":"Income"
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
   this.dropdown();
   this.getcattype();
  }
  dropdown(){
    this.dd=this.dropstatus
    }
  getcattype() {  
    debugger;
    //this.myexpense.getAccountList(this.uid).subscribe(
      //data => {
        this.messagetype= this.data;

        //console.log(this.nameList);
      /*},
      (err) => {
        this.error = err;
      }
    ); */
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
  getMember(data1 :any) {  
    debugger;
    let accountid = data1.account_id;
  
    this.myexpense.getMemberList(accountid).subscribe(
    res => {
      this.memberList = res;

    //  console.log(this.expenses);
    },
    (err) => {
      this.error = err;
    }
  );
    // this.nameList=this.data;
  } 
 
  getReport() {  
    debugger;
    
     this.reportList=this.data;
  } 
  selectpenstatus(){



  }
  search(){
    debugger;
    if(this.type != null && this.accountid != null && this.fromdate!=null && this.todate!=null && this.catid!=null && this.subcatid!=null && this.memid!=null){
      this.myexpense.getSearchData(this.type,this.accountid,this.fromdate,this.todate,this.catid,this.subcatid,this.memid,this.penstatus)
      .subscribe(  
       res => {
      this.groupreports = res;
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
      for(let item of this.groupreports){
        var aid = item.totalamount
var icon =item.symbol;
      }
     
      this.totalamount =aid;
      this.currencyicons=icon;
    this.mybutton=true;
      //this.userservice.alertMsg(res)
      this.searchResult = true
    
      console.log(this.groupreports);
    },
    (err) => {
      this.error = err;
    }
  );
    }
    else{
      swal("Fields cannot be empty!")
    }
  }
  
    public refreshList(){
      //this.getList();
     }
  selectacc() {
   
    var q=7
    //var type=1
  
    this.myexpense.getCategoryList(this.accountid,this.type,q).subscribe(
      res => {
        this.categorylist = res;
          console.log(this.categorylist)
         },
        (err) => {
          this.error = err;
        }
      );
    this.myexpense.getMemberList(this.accountid).subscribe(
      res => {
        this.memberlist = res;
          //this.userservice.alertMsg(this.memberlist);
          console.log(this.memberlist)
         },
        (err) => {
          this.error = err;
        }
      );
  
  } 
  
  selectName() {  
  
  } 
  selectType() {  
   
  } 
  selectmemid(){
   
  }
  selectcat() {
     
    var q=3
    this.myexpense.getSubCategoryList(this.catid,q).subscribe(
      res => {
        this.subcategorylist = res;
        console.log(this.subcategorylist)
       },
      (err) => {
        this.error = err;
      }
    );

  }
  selectsubcat(){


  }
  
}
