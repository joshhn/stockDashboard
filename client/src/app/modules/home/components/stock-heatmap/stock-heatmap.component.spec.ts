import { ComponentFixture, TestBed } from '@angular/core/testing';

import { StockHeatmapComponent } from './stock-heatmap.component';

describe('StockHeatmapComponent', () => {
  let component: StockHeatmapComponent;
  let fixture: ComponentFixture<StockHeatmapComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [StockHeatmapComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(StockHeatmapComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
