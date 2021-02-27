import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { NewexpensesComponent } from './newexpenses.component';

describe('NewexpensesComponent', () => {
  let component: NewexpensesComponent;
  let fixture: ComponentFixture<NewexpensesComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ NewexpensesComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(NewexpensesComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
