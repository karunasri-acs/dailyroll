export class Expense {
  constructor(
  
    public accname ?:  string,
    public accountid ?:  string,
    public amount ?:  string,
    public catid ?:string,
    public catname ?: string,
    public date ?: string,
    public description ?: string,
    public expense_id ?: string,
    public subcatid ?: string,
    public subcatname?: string,
    public pendingstatus?: string,
    public pendingamount?: string,
    public operations?: string
    ) { }


  }