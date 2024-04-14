import { Component } from '@angular/core';
import { Router } from '@angular/router';
import { FormsModule } from '@angular/forms';
import { NgIf, NgFor, NgStyle } from '@angular/common';
import { StockService } from '../../services/stock.service';
import { Stock } from '../../models/stock';

@Component({
  selector: 'app-searchbar',
  standalone: true,
  imports: [FormsModule, NgIf, NgFor, NgStyle],
  templateUrl: './searchbar.component.html',
  styleUrl: './searchbar.component.css'
})
export class SearchbarComponent {
  query: string;
  stocks: Stock[];
  errorMessage: string;
  isResultsVisible: boolean;

  constructor(private router: Router, private stockService: StockService) {
    this.query = '';
    this.errorMessage = '';
    this.isResultsVisible = false;
    this.stocks = [];
  }

  ngOnInit() {
    this.stockService.getStocks(5).subscribe({
      next: data => {
        this.stocks = data;
        this.errorMessage = '';
      },
      error: err => {
        this.errorMessage = err.error;
      }
    });
  }

  onInputChange(): void {
    this.stockService.searchStock(this.query).subscribe({
      next: data => {
        this.stocks = data;
        this.errorMessage = '';
      },
      error: err => {
        this.errorMessage = err.error;
      }
    });
  }

  openTicker(ticker: string | undefined) {
    this.router.navigateByUrl(`/stocks/${ticker}`).then(() => {
      window.location.reload();
    });;
  }

  showResults(): void {
    this.isResultsVisible = true;
  }

  hideResults(): void {
    setTimeout(() => {
      this.isResultsVisible = false;
    }, 100);
  }
}
