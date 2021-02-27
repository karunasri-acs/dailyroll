import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { MyexpenseComponent } from './myexpense.component';

describe('MyexpenseComponent', () => {
  let component: MyexpenseComponent;
  let fixture: ComponentFixture<MyexpenseComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ MyexpenseComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(MyexpenseComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
