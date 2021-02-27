import { StarterComponent } from './../starter/starter.component';
import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { RouterModule, PreloadAllModules,  Routes } from '@angular/router';
import { LoginComponent } from '../starter/login/login.component';
import { RegisterComponent } from '../starter/register/register.component';
//import { expireduserComponent } from '../expireduser/expireduser.component';
import { ForgetpassComponent } from '../starter/forgetpass/forgetpass.component';
import { LatestnewsComponent } from '../starter/latestnews/latestnews.component';
import { LinkednewsComponent } from '../starter/linkednews/linkednews.component';
import { AdscomponentComponent } from '../starter/adscomponent/adscomponent.component';
import { SelectiveStrategy } from '../selective-strategy.service';
import { SocialloginComponent } from '../starter/sociallogin/sociallogin.component';

export const routes: Routes = [
  { path: '', redirectTo: 'login', pathMatch: 'full' },
  { path: 'starter', component: StarterComponent },
  { path: 'login', component: LoginComponent },
  { path: 'register', component: RegisterComponent },
  { path: 'forgetpass', component: ForgetpassComponent },
  { path: 'latestnews', component: LatestnewsComponent },
  { path: 'linkednews', component: LinkednewsComponent },
  { path: 'ads', component: AdscomponentComponent},
  { path: 'sociallogin', component: SocialloginComponent},
  {
    path: 'dailyroll',
    data: { preload: true },
    loadChildren: () => import('../dailyroll/daily.module').then(m => m.DailyrollModule)
    //loadChildren: () =>
    //import('../dailyroll/daily.module').then(m => m.DailyrollModule)
   },
   {
    path: 'expireduser',
    data: { preload: true },
    loadChildren: () => import('../expireduser/expireduser.module').then(m => m.expireduserModule)
    //loadChildren: () =>
    //import('../expireduser/expireduser.module').then(m => m.expireduserModule)
   }];
@NgModule({
  imports: [

    RouterModule.forRoot([
      { path: '', redirectTo: 'login', pathMatch: 'full' },
      { path: 'starter', component: StarterComponent },
      { path: 'login', component: LoginComponent },
      { path: 'register', component: RegisterComponent },
      { path: 'forgetpass', component: ForgetpassComponent },
      { path: 'latestnews', component: LatestnewsComponent },
      { path: 'linkednews', component: LinkednewsComponent },
      { path: 'ads', component: AdscomponentComponent},
      { path: 'sociallogin', component: SocialloginComponent},
      {
        path: 'dailyroll',
        data: { preload: true },
        loadChildren: () => import('../dailyroll/daily.module').then(m => m.DailyrollModule)
       },
       {
        path: 'expireduser',
        data: { preload: true },
        loadChildren: () => import('../expireduser/expireduser.module').then(m => m.expireduserModule)
       }
       
    ])
  ],
 exports: [ RouterModule]
})
export class AppRoutingModule { }
