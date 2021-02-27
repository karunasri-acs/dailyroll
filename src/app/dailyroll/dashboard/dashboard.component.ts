import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { DashboardService } from '../../services/dashboard.service';
import { Color } from 'ng2-charts';
import { ThrowStmt } from '@angular/compiler';
@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.css']
})
export class DashboardComponent implements OnInit {
  dataSource: Object;
  uid:string='';
  accountid:any;
  amount:string;
  messagetype:any;
  description : string;
  date :string;
  accounts :any;
  income:any;
  expense:any;
  alertcount:any;
  error: any;
  data: any;
  accountslist:any;
  pieRes:any;
  dataSource1; 
  periodtype = 'Untill Today';
  charRes:any;

 data1:any;
  constructor(private router:Router, private count:DashboardService) {
    //this.loginService.getusers
    
   

   }
 
  ngOnInit(): void {
    // generate random values for mainChart
    if(sessionStorage.getItem('uid')!= null){
      //this.count=this.getList();
      this.uid = sessionStorage.getItem('uid');
     }
     this.data=[
      {
      "catname":"Untill Today"
      },
      {
        "catname":"Current Month"
        },
        {
          "catname":"Current Year"
          }
      
      ] 
    this.getList();
    this.getExpense();
    this.getIncome();
    this. getAccounts();
    this.getcattype();
    
  
     
  }

 
  getAccounts() {
    var q=1
        debugger;
       
        this.count.getAccountsList(this.uid,q).subscribe(
          res => {
            this.accountslist = res;
            for(let item of this.accountslist){
              var aid = item.account_id

            }
           
            this.accountid =aid;
           // this.userservice.alertMsg(this.accountid);
            this.getpiechart();
            this.getbarchat();
            console.log(this.accountslist)
           },
          (err) => {
            this.error = err;
          }
        );
      }
      getList() {

        debugger;
        this.count.getaccountcount(this.uid).subscribe(
          res => {
            this.accounts = res;

          //  console.log(this.expenses);
          },
          (err) => {
            this.error = err;
          }
        );
      }
      getExpense() {

      debugger;
      this.count.getExpcount(this.uid).subscribe(
        res => {
          this.expense = res;

        //  console.log(this.expenses);
        },
        (err) => {
          this.error = err;
        }
      );
    }
  
   
    getcattype() {  
      debugger;
       this.messagetype= this.data;
  
    }
    getIncome() {

      debugger;
      this.count.getincome(this.uid).subscribe(
        res => {
          this.income = res;

        //  console.log(this.expenses);
        },
        (err) => {
          this.error = err;
        }
      );
    }
  
   getpiechart(){
    var q=1;
     
    //this.userservice.alertMsg(this.accountid);
     this.count.getPieChart(this.uid,this.accountid,this.periodtype,q).subscribe(
       res => {
         this.pieRes = res;
         console.log(this.pieRes);
         this.data1 = {
          chart: {
            theme: "fusion",
            "palettecolors":"5d62b5,29c3be,f2726f"
           },
          data:this.pieRes
         
        
        };
            
       })


   }
   selectacc(){
   
    var q=1;
     
    //this.userservice.alertMsg('ad');
     this.count.getPieChart(this.uid,this.accountid,this.periodtype,q).subscribe(
       res => {
         this.pieRes = res;
         console.log(this.pieRes);
         this.data1 = {
          chart: {
            
            theme: "fusion",
            "palettecolors":"5d62b5,29c3be"
           },
          data:this.pieRes
         
        
        };
            
       })
       var q=2;
       //this.accountid =2
       this.count.getBarChart(this.uid,this.accountid,this.periodtype,q).subscribe(
         res => {
           this.charRes = res;
         
         console.log(this.pieRes);
         this.dataSource = {
          chart: {
            theme: "fusion",
            "palettecolors":"5d62b5,29c3be,f2726f"
          },
          // Chart Data
          data: this.charRes
        }
       
            
       })
  
  }
  selectperiod(){
   // this.userservice.alertMsg(this.periodtype);
    var q=1;
     
    //this.userservice.alertMsg('ad');
     this.count.getPieChart(this.uid,this.accountid,this.periodtype,q).subscribe(
       res => {
         this.pieRes = res;
         console.log(this.pieRes);
         this.data1 = {
          chart: {
            theme: "fusion",
            "palettecolors":"5d62b5,29c3be"
           },
          data:this.pieRes
         
        
        };
            
       })
       var q=2;
       //this.accountid =2
       this.count.getBarChart(this.uid,this.accountid,this.periodtype,q).subscribe(
         res => {
           this.charRes = res;
         
         console.log(this.pieRes);
         this.dataSource = {
          chart: {
            theme: "fusion",
            "palettecolors":"5d62b5,29c3be,f2726f"
 

          },
          // Chart Data
          data: this.charRes
        }
       
            
       })

  
  
  }
   getbarchat(){
   // this.userservice.alertMsg(this.accountid);
    var q=2;
    //this.accountid =2
    this.count.getBarChart(this.uid,this.accountid,this.periodtype,q).subscribe(
      res => {
        this.charRes = res;
      
      console.log(this.pieRes);
      this.dataSource = {
       chart: {
      
        theme: "fusion",
        "palettecolors":"5d62b5,29c3be,f2726f"
       },
       // Chart Data
       data: this.charRes
     }
    
         
    })


   } 
    
}
