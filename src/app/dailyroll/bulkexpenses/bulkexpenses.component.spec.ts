import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BulkexpensesComponent } from './bulkexpenses.component';

describe('BulkexpensesComponent', () => {
  let component: BulkexpensesComponent;
  let fixture: ComponentFixture<BulkexpensesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BulkexpensesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BulkexpensesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
