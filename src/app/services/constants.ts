export class AppSettings {
  furl :any;
  static getUrl() {

   var t = window.location.href;
 //var t = 'https://devang.dailyroll.org/member/#/login';

    var tt = t.substr(0, t.lastIndexOf('/#'));
    this.furl = tt+'/dailyroll-api'; 
    //throw new Error("Method not implemented.");
    return this.furl
  }
  static furl: any;
  
   public static get BASE_URL(): string { 
     this.getUrl();
     return this.furl;
     } 
}

