import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component } from '@angular/core';

@Component({
  selector: 'app-stock-heatmap',
  standalone: true,
  templateUrl: './stock-heatmap.component.html',
  styleUrl: './stock-heatmap.component.css'
})
export class StockHeatmapComponent implements AfterViewInit {

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) {}

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-stock-heatmap.js";
    script.text = `
    {
      "exchanges": [],
      "dataSource": "SPX500",
      "grouping": "sector",
      "blockSize": "market_cap_basic",
      "blockColor": "change",
      "locale": "en",
      "symbolUrl": "",
      "colorTheme": "light",
      "hasTopBar": false,
      "isDataSetEnabled": false,
      "isZoomEnabled": true,
      "hasSymbolTooltip": true,
      "width": "1410",
      "height": "400"
    }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}