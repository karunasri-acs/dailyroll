
import { Injectable } from '@angular/core';
import { CanActivate, ActivatedRouteSnapshot, RouterStateSnapshot } from '@angular/router';
import { UserServiceService} from '../services/user-service.service'
import swal from 'sweetalert';
@Injectable()
export class OnlyLoggedInUsersGuard implements CanActivate {
  auth_code: string; 
  constructor(private userService: UserServiceService) {
    if(sessionStorage.getItem('authcode')!= null){
      this.auth_code = sessionStorage.getItem('authcode');
     // this.userservice.alertMsg(this.authcode)
   }
  }; 

  canActivate() {
    console.log("OnlyLoggedInUsers");
    if (this.userService.isLoggedIn()) { 
      return true;
    } else {
      swal({
        title: "Sorry !!",
        text: "You don't have permission to view this page",
        icon: "warning",
        dangerMode: true,
      });
      //swal("You don't have permission to view this page");
      return false;
    }
  }

  canAuthenticate() {
    console.log("Authentication");
    if (this.auth_code === "YES") { 
      return true;
    } else {
      return false;
    }
  }
}
