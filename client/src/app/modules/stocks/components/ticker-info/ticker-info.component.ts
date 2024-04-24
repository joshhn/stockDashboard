import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component, Input } from '@angular/core';

@Component({
  selector: 'app-ticker-info',
  standalone: true,
  templateUrl: './ticker-info.component.html',
  styleUrl: './ticker-info.component.css'
})
export class TickerInfoComponent implements AfterViewInit {
  @Input() ticker: string;

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) { 
    this.ticker = '';
  }

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-symbol-info.js";
    script.text = `
    {
      "symbol": "${this.ticker}",
      "width": 1410,
      "locale": "en",
      "colorTheme": "light",
      "isTransparent": false
    }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}
