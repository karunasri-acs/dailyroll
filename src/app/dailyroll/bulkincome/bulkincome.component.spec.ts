import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { BulkincomeComponent } from './bulkincome.component';

describe('BulkincomeComponent', () => {
  let component: BulkincomeComponent;
  let fixture: ComponentFixture<BulkincomeComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ BulkincomeComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(BulkincomeComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
