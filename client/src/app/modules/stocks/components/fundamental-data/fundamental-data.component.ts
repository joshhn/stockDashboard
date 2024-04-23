import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component, Input } from '@angular/core';

@Component({
  selector: 'app-fundamental-data',
  standalone: true,
  imports: [],
  templateUrl: './fundamental-data.component.html',
  styleUrl: './fundamental-data.component.css'
})
export class FundamentalDataComponent implements AfterViewInit {
  @Input() ticker: string;

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) { 
    this.ticker = '';
  }

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-financials.js";
    script.text = `
    {
      "isTransparent": false,
      "largeChartUrl": "",
      "displayMode": "regular",
      "width": 410,
      "height": 500,
      "colorTheme": "light",
      "symbol": "${this.ticker}",
      "locale": "en"
    }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}