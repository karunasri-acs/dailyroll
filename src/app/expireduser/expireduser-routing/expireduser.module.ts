import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule } from '@angular/router';
import { expireduserComponent } from '../expireduser.component';
import { DashboardComponent } from '../dashboard/dashboard.component';
import { MyexpenseComponent } from '../myexpense/myexpense.component';
import { MyincomeComponent } from '../myincome/myincome.component';
import { ProfileComponent } from '../profile/profile.component';
import { AccountsComponent } from '../accounts/accounts.component';
import { GroupreportsComponent } from '../groupreports/groupreports.component';
import { ResetComponent } from '../reset/reset.component';
import { ViewaccountsComponent } from '../viewaccounts/viewaccounts.component';
import { ViewaccountsListComponent } from '../viewaccounts-list/viewaccounts-list.component';
import { CategoryComponent } from '../category/category.component';
import { RenewalComponent } from '../renewal/renewal.component';
import { FeedbackComponent} from '../feedback/feedback.component';
import { ExpadsComponent } from '../expads/expads.component';
import { AlwaysAuthGuardGuard } from '../../starter/always-auth-guard.guard';
import { OnlyLoggedInUsersGuard } from '../../starter/only-logged-in-users-guard.guard';
import {TreeexpComponent} from '../treeexp/treeexp.component';
@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component:expireduserComponent,
        canActivate: [OnlyLoggedInUsersGuard,AlwaysAuthGuardGuard],
        children: [
          {
            path: '',
            redirectTo: 'dashboard',
            pathMatch: 'full'
          },
          {
            path: 'dashboard',
            component: DashboardComponent
          },
          {
            path: 'myexpense',
              component: MyexpenseComponent
              
          },
          {
            path: 'expads',
              component: ExpadsComponent
              
          },
          {
            path: 'myincome',
              component: MyincomeComponent
              
          },
          {
            path: 'profile',
              component: ProfileComponent
              
          },
          {
            path: 'accounts',
              component: AccountsComponent
              
          },
          {
            path: 'groupreports',
              component: GroupreportsComponent
              
          },
          {
            path: 'reset',
              component: ResetComponent
                  
          },
          {
            path: 'viewaccount',
              component: ViewaccountsComponent
              
          },
          {
            path: 'viewaccountlist',
              component: ViewaccountsListComponent
              
          },
          {
            path: 'category',
              component: CategoryComponent
              
          },
          {
            path: 'renewel',
              component:  RenewalComponent
              
          },
          {
            path: 'feedback',
              component:  FeedbackComponent
              
          },

          {
            path: 'business',
              component: TreeexpComponent
              
          }
        ]
      }            
          
      
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class expireduserRoutingModule { }
