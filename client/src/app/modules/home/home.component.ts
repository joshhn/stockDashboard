import { Component } from '@angular/core';
import { NgFor } from '@angular/common';
import { NavbarComponent } from '../../shared/navbar/navbar.component';
import { TickerTapeComponent } from '../../shared/ticker-tape/ticker-tape.component';
import { MarketOverviewComponent } from '../../shared/market-overview/market-overview.component';
import { TopStoriesComponent } from '../../shared/top-stories/top-stories.component';
import { ReferenceService } from '../../services/reference.service';
import { News } from '../../models/news';
import { NewsComponent } from './components/news/news.component';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [NgFor, NavbarComponent, NewsComponent, TickerTapeComponent, MarketOverviewComponent, TopStoriesComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {
  newsList: News[] | undefined;

  constructor(private refService: ReferenceService) { }

  ngOnInit(): void {
    this.fetchNews();
  }

  fetchNews(): void {
    this.refService.getNews().subscribe({
      next: data => {
        this.newsList = data.results;
      },
      error: err => {
        console.log(err);
      }
    });
  }
}
