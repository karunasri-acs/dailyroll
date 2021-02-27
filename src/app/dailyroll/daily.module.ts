import { NgModule } from '@angular/core';
import { DailyrollComponent } from "./dailyroll.component";
import { RouterModule } from '@angular/router';
import { DailyRoutingModule } from "./daily-routing/daily-routing.module";
import {FormsModule} from '@angular/forms';
import { CommonModule } from '@angular/common';
import { LocationStrategy, HashLocationStrategy } from '@angular/common';
import { AccountsComponent } from "./accounts/accounts.component";
import { GroupreportsComponent } from "./groupreports/groupreports.component";
import { ProfileComponent } from "./profile/profile.component";
import { MyincomeComponent } from "./myincome/myincome.component";
import { MyexpenseComponent } from "./myexpense/myexpense.component";
import { DashboardComponent } from "./dashboard/dashboard.component";
import { HeaderComponent } from "./header/header.component";
import { FooterComponent } from "./footer/footer.component";
import { LeftSideComponent } from "./left-side/left-side.component";
import { CategoryService } from '../services/category.service';
import { DataTablesModule } from 'angular-datatables';
import { ResetComponent } from "./reset/reset.component";
import { ViewaccountsComponent } from './viewaccounts/viewaccounts.component';
import { ViewaccountsListComponent } from './viewaccounts-list/viewaccounts-list.component';
import { CategoryComponent } from './category/category.component';
import { FeedbackComponent } from './feedback/feedback.component';
import { AlllistComponent } from './alllist/alllist.component';
import { BulkincomeComponent } from './bulkincome/bulkincome.component';
import { BulkexpensesComponent } from './bulkexpenses/bulkexpenses.component';
import { FusionChartsModule } from "angular-fusioncharts";
import { Dailyadscomponent } from "./dailyadscomponent/dailyadscomponent.component";
// Import FusionCharts library and chart modules
import * as FusionCharts from "fusioncharts";
import * as Charts from "fusioncharts/fusioncharts.charts";
import * as FusionTheme from "fusioncharts/themes/fusioncharts.theme.fusion";
import { LatestnewsComponent } from './latestnews/latestnews.component';
import { BalancesheetComponent } from './balancesheet/balancesheet.component';
FusionChartsModule.fcRoot(FusionCharts, Charts, FusionTheme);

//from app module copied
import { FullCalendarModule } from 'ng-fullcalendar';
import { NotificationsComponent } from './notifications/notifications.component';
FusionChartsModule.fcRoot(FusionCharts, Charts, FusionTheme);
import { MatTreeModule } from '@angular/material/tree';
import { TreeexpComponent } from './treeexp/treeexp.component';
import { NewexpensesComponent } from './newexpenses/newexpenses.component';
@NgModule({
    imports: [
      //from app module
    FullCalendarModule,
    FusionChartsModule,
    DataTablesModule.forRoot(),
    MatTreeModule,
  
  //from this module
      CommonModule,
      DailyRoutingModule,
      FormsModule,
      RouterModule.forChild([
        {
          path: '',
          component: DashboardComponent
        }])
      
    ],
    declarations: [
      DailyrollComponent,
      GroupreportsComponent,
      AccountsComponent,
      ProfileComponent,
      MyincomeComponent,
      MyexpenseComponent,
      DashboardComponent,
      HeaderComponent,
      FooterComponent,
      LeftSideComponent,
      ResetComponent,
      Dailyadscomponent,
      ViewaccountsComponent,
      ViewaccountsListComponent,
      CategoryComponent,
      FeedbackComponent,
      AlllistComponent,
      BulkincomeComponent,
      BulkexpensesComponent,
      LatestnewsComponent,
      BalancesheetComponent,
      NotificationsComponent,
      TreeexpComponent,
      NewexpensesComponent,
     
    
    ],
    providers: [
      
    CategoryService,
      {
      provide: LocationStrategy,
      useClass: HashLocationStrategy
    }]
    ,
   // exports: [DailyrollComponent]
   
  })
  export class DailyrollModule { }