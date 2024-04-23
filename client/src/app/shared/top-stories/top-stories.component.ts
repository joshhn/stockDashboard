import { AfterViewInit, ElementRef, Renderer2, ViewChild, Component } from '@angular/core';

@Component({
  selector: 'app-top-stories',
  standalone: true,
  templateUrl: './top-stories.component.html',
  styleUrl: './top-stories.component.css'
})
export class TopStoriesComponent implements AfterViewInit {

  @ViewChild('tradingview') tradingview?: ElementRef;

  constructor(private _renderer2: Renderer2) { }

  ngAfterViewInit(): void {
    let script = this._renderer2.createElement('script');
    script.type = `text/javascript`;
    script.src = "https://s3.tradingview.com/external-embedding/embed-widget-timeline.js";
    script.text = `
    {
      "feedMode": "all_symbols",
      "isTransparent": false,
      "displayMode": "regular",
      "width": 400,
      "height": 550,
      "colorTheme": "light",
      "locale": "en"
    }`;
  
    this.tradingview?.nativeElement.appendChild(script);
  }
}
