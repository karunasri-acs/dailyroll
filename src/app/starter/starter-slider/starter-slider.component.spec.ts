import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { StarterSliderComponent } from './starter-slider.component';

describe('StarterSliderComponent', () => {
  let component: StarterSliderComponent;
  let fixture: ComponentFixture<StarterSliderComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ StarterSliderComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(StarterSliderComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
