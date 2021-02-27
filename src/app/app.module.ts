import { DataTablesModule } from 'angular-datatables';
import { AppRoutingModule } from './app-routing/app-routing.module';
import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { AppComponent } from './app.component';
import { StarterComponent } from './starter/starter.component';
import { StarterHeaderComponent } from './starter/starter-header/starter-header.component';
import { StarterContentComponent } from './starter/starter-content/starter-content.component';
import { StarterFooterComponent } from './starter/starter-footer/starter-footer.component';
import { LoginComponent } from './starter/login/login.component';
import { RegisterComponent } from './starter/register/register.component';
import { FormsModule } from '@angular/forms';
import { HttpClientModule, HTTP_INTERCEPTORS } from '@angular/common/http';
import { SelectiveStrategy } from './selective-strategy.service';
import { AdscomponentComponent } from './starter/adscomponent/adscomponent.component';
import { StarterSliderComponent } from './starter/starter-slider/starter-slider.component';
import { HeaderComponent } from './starter/header/header.component';
import { FooterComponent } from './starter/footer/footer.component';
import { ForgetpassComponent } from './starter/forgetpass/forgetpass.component';
import { LatestnewsComponent } from './starter/latestnews/latestnews.component';
import { LinkednewsComponent } from './starter/linkednews/linkednews.component';

/*
import { FusionChartsModule } from "angular-fusioncharts";
// Import FusionCharts library and chart modules
import * as FusionCharts from "fusioncharts";
import * as Charts from "fusioncharts/fusioncharts.charts";
import * as FusionTheme from "fusioncharts/themes/fusioncharts.theme.fusion";
// Pass the fusioncharts library and chart modules
import { FullCalendarModule } from 'ng-fullcalendar';
FusionChartsModule.fcRoot(FusionCharts, Charts, FusionTheme);
*/

//import {AlertService} from './services/alert.service';
import { LocationStrategy, HashLocationStrategy } from '@angular/common';
import { RegisterServiceService } from './services/register-service.service';
import { LoginServiceService } from './services/login-service.service';
import { AccountService } from './services/account.service';
import {DashboardService} from './services/dashboard.service';
import {ForgetService} from './services/forget.service';
import {GroupreportService} from './services/groupreport.service';
import {MyexpenseService} from './services/myexpense.service';
import {MyincomeService} from './services/myincome.service';
import {ProfileService} from './services/profile.service';
import {ReportsService} from './services/reports.service';
import {ViewaccountService} from './services/viewaccount.service';
import {ResetService} from './services/reset.service';
import { UserServiceService} from './services/user-service.service';
import { ENCRYPTSERVICE} from './services/encrypt.service';
import { AlwaysAuthGuardGuard } from './starter/always-auth-guard.guard';
import { OnlyLoggedInUsersGuard} from './starter/only-logged-in-users-guard.guard';
import { SocialloginComponent } from './starter/sociallogin/sociallogin.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { MatCheckboxModule } from '@angular/material/checkbox';

import { LayoutModule } from '@angular/cdk/layout';
import { MatToolbarModule } from '@angular/material/toolbar';
import { MatButtonModule } from '@angular/material/button';
import { MatSidenavModule } from '@angular/material/sidenav';
import { MatIconModule } from '@angular/material/icon';
import { MatListModule } from '@angular/material/list';

import { MatTableModule } from '@angular/material/table';
import { MatPaginatorModule } from '@angular/material/paginator';
import { MatSortModule } from '@angular/material/sort';

import { MatGridListModule } from '@angular/material/grid-list';
import { MatCardModule } from '@angular/material/card';
import { MatMenuModule } from '@angular/material/menu';
import { MatTreeModule } from '@angular/material/tree';
import {MatBadgeModule} from '@angular/material/badge';

@NgModule({
  declarations: [
    AppComponent,
    StarterComponent,
    StarterHeaderComponent,
    //StarterLeftSideComponent,
    StarterContentComponent,
    StarterFooterComponent,
    //StarterControlSidebarComponent,
    LoginComponent,
    RegisterComponent,
    StarterSliderComponent,
    HeaderComponent,
    FooterComponent,
    ForgetpassComponent,
    LatestnewsComponent,
    AdscomponentComponent,
    LinkednewsComponent,
    SocialloginComponent,
  ],
  imports: [
    BrowserModule,
   
    AppRoutingModule,
    FormsModule,
    MatButtonModule,
    HttpClientModule,
    BrowserAnimationsModule,
    MatCheckboxModule,
    LayoutModule,
    MatToolbarModule,
    MatButtonModule,
    MatSidenavModule,
    MatIconModule,
    MatListModule,
    MatTableModule,
    MatPaginatorModule,
    MatSortModule,
    MatGridListModule,
    MatCardModule,
    MatMenuModule,
    MatTreeModule,
    MatBadgeModule

    /*,
    FullCalendarModule,
    FusionChartsModule,
    DataTablesModule.forRoot(),
    FusionChartsModule,
    expireduserModule
    */
  ],
  providers: [
   
    
    AlwaysAuthGuardGuard,
    OnlyLoggedInUsersGuard,
    UserServiceService,
    ENCRYPTSERVICE,
    SelectiveStrategy,
    RegisterServiceService,
    LoginServiceService,
    AccountService,
    DashboardService,
    ForgetService,
    GroupreportService,
    MyexpenseService,
    MyincomeService,
    ProfileService,
    ReportsService,
    ViewaccountService,
    ResetService,
    {provide: LocationStrategy, useClass: HashLocationStrategy}
    

   ],
  bootstrap: [AppComponent]
})
export class AppModule { }
