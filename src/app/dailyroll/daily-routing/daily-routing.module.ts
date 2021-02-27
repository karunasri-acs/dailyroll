import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
import { DailyrollComponent } from '../dailyroll.component';
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
import { FeedbackComponent } from '../feedback/feedback.component';
import { AlllistComponent  } from '../alllist/alllist.component';
import {  BulkexpensesComponent } from '../bulkexpenses/bulkexpenses.component';
import { BulkincomeComponent } from '../bulkincome/bulkincome.component';
import { BalancesheetComponent} from '../balancesheet/balancesheet.component';
import { Dailyadscomponent } from '../dailyadscomponent/dailyadscomponent.component';
import { AlwaysAuthGuardGuard } from '../../starter/always-auth-guard.guard';
import { OnlyLoggedInUsersGuard } from '../../starter/only-logged-in-users-guard.guard';
import { NotificationsComponent } from '../notifications/notifications.component';
import {TreeexpComponent} from '../treeexp/treeexp.component';
import {NewexpensesComponent} from '../newexpenses/newexpenses.component';
@NgModule({
  imports: [
    RouterModule.forChild([
      {
        path: '',
        component: DailyrollComponent,
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
          path: 'dailyads',
           component: Dailyadscomponent
          },
        {
            path: 'myexpense',
              component: MyexpenseComponent
              
          },
          {
            path: 'bulkexpense',
              component: BulkexpensesComponent
              
          },
          {
            path: 'bulkincome',
              component: BulkincomeComponent
              
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
            path: 'feedback',
              component: FeedbackComponent
              
          },
          {
            path: 'alllist',
              component: AlllistComponent
              
          },
          
          {
            path: 'balancesheet',
              component: BalancesheetComponent
              
          },
          {
            path: 'notifications',
              component: NotificationsComponent
              
          },
          {
            path: 'business',
              component: TreeexpComponent
              
          },
          {
            path: 'newexpenses',
              component: NewexpensesComponent
              
          }
        ]

      }            
          
      
    ])
  ],
  exports: [
    RouterModule
  ]
})
export class DailyRoutingModule { }
