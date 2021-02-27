import { Component, OnInit } from '@angular/core';
import { MyexpenseService } from '../../services/myexpense.service';
import swal from 'sweetalert';
@Component({
  selector: 'app-forgetpass',
  templateUrl: './forgetpass.component.html',
  styleUrls: ['./forgetpass.component.css']
})
export class ForgetpassComponent implements OnInit {
  email:any;
  constructor(private expenseservice:MyexpenseService ) { }

  ngOnInit() {
  }
  createUser(){
    if(this.email != null){
        this.expenseservice.forgotpass(this.email)
        .subscribe(
          res=> {
            setTimeout(() => {  
              debugger;
             
              swal(res);
           
            }, 2000);
          
            } );
    this.email=null;
    this.email=''
    
      }
      else{
    
    swal('please enter email');
      }
    }
}
