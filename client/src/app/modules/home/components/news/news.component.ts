import { Component, Input } from '@angular/core';
import { NgFor } from '@angular/common';
import { Router } from '@angular/router';
import { News } from '../../../../models/news';

@Component({
  selector: 'app-news',
  standalone: true,
  imports: [NgFor],
  templateUrl: './news.component.html',
  styleUrl: './news.component.css'
})
export class NewsComponent {
  @Input() news!: News;

  constructor(private router: Router) {}

  openArticle() {
    window.open(this.news.article_url, '_blank');
  }

  openTicker(event: MouseEvent, ticker: string) {
    event.stopPropagation();
    this.router.navigateByUrl(`/stocks/${ticker}`);
  }
}
