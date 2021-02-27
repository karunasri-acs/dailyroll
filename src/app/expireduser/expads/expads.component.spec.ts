import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { ExpadsComponent } from './expads.component';

describe('ExpadsComponent', () => {
  let component: ExpadsComponent;
  let fixture: ComponentFixture<ExpadsComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ ExpadsComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(ExpadsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
