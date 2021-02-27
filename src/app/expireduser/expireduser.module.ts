import { expireduserComponent } from "./expireduser.component";
import {expireduserRoutingModule } from "./expireduser-routing/expireduser.module";
import {FormsModule} from '@angular/forms';
import { NgModule } from '@angular/core';
import { RouterModule } from '@angular/router';
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
import { ContentComponent } from "./content/content.component";
import { CategoryService } from '../services/category.service';
import { DataTablesModule } from 'angular-datatables';
import { ResetComponent } from "./reset/reset.component";
import { ViewaccountsComponent } from './viewaccounts/viewaccounts.component';
import { ViewaccountsListComponent } from './viewaccounts-list/viewaccounts-list.component';
import { CategoryComponent } from './category/category.component';
import { RenewalComponent } from './renewal/renewal.component';
import { FeedbackComponent } from './feedback/feedback.component';
import { FusionChartsModule } from "angular-fusioncharts";
// Import FusionCharts library and chart modules
import * as FusionCharts from "fusioncharts";
import * as Charts from "fusioncharts/fusioncharts.charts";
import * as FusionTheme from "fusioncharts/themes/fusioncharts.theme.fusion";
import { BalancesheetComponent } from './balancesheet/balancesheet.component';
import { ExpadsComponent } from './expads/expads.component';
FusionChartsModule.fcRoot(FusionCharts, Charts, FusionTheme);
//from app module copied
import { FullCalendarModule } from 'ng-fullcalendar';
import { TreeexpComponent } from './treeexp/treeexp.component';
import { MatTreeModule } from '@angular/material/tree';
FusionChartsModule.fcRoot(FusionCharts, Charts, FusionTheme);

@NgModule({
    imports: [
       //from app module
    FullCalendarModule,
    FusionChartsModule,
    DataTablesModule.forRoot(),
    MatTreeModule,
  //from this module
      CommonModule,
      expireduserRoutingModule,
      FormsModule,
      FusionChartsModule,
      DataTablesModule.forRoot(),
      RouterModule.forChild([
        {
          path: '',
          component: DashboardComponent
        }])
    ],
    declarations: [
      expireduserComponent,
      GroupreportsComponent,
      AccountsComponent,
      ProfileComponent,
      MyincomeComponent,
      MyexpenseComponent,
      DashboardComponent,
      HeaderComponent,
      FooterComponent,
      LeftSideComponent,
      ContentComponent,
      ResetComponent,
      ViewaccountsComponent,
      ViewaccountsListComponent,
      CategoryComponent,
      RenewalComponent,
      FeedbackComponent,
      BalancesheetComponent,
      ExpadsComponent,
      TreeexpComponent
    
    ],
    providers: [  
//from this module
    CategoryService,
  
      {
      provide: LocationStrategy,
      useClass: HashLocationStrategy
    }],
   // exports: [ expireduserComponent]
  })
  export class  expireduserModule { }