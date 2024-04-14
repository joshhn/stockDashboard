import { Component } from '@angular/core';
import { NgFor } from '@angular/common';
import { Watchlist } from '../../../../models/watchlist';
import { WatchlistService } from '../../../../services/watchlist.service';

@Component({
  selector: 'app-watchlist',
  standalone: true,
  imports: [NgFor],
  templateUrl: './watchlist.component.html',
  styleUrl: './watchlist.component.css'
})
export class WatchlistComponent {
  watchlists: Watchlist[];
  errorMessage: string;

  constructor(private watchlistService: WatchlistService) {
    this.watchlists = [];
    this.errorMessage = '';
  }

  ngOnInit() {
    this.watchlistService.getWatchlists().subscribe({
      next: data => {
        this.watchlists = data;
        console.log(data)
      },
      error: err => {
        console.log(err);
      }
    });
  }

  createWatchlist() {
    this.watchlistService.create('Testname').subscribe({
      next: data => {
        this.watchlists.push(data);
      },
      error: err => {
        console.log(err);
      }
    });
  }
}
