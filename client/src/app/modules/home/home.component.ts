import { Component } from '@angular/core';
import { NgFor } from '@angular/common';
import { NavbarComponent } from '../../shared/navbar/navbar.component';
import { StockService } from '../../services/stock.service';
import { Stock } from '../../models/stock';

@Component({
  selector: 'app-home',
  standalone: true,
  imports: [NgFor, NavbarComponent],
  templateUrl: './home.component.html',
  styleUrl: './home.component.css'
})
export class HomeComponent {
  stocks: Stock[] | undefined;

  constructor(private stockService: StockService) { }

  ngOnInit(): void {
    this.fetchStocks();
  }

  fetchStocks(): void {
    this.stockService.getStocks().subscribe(stocks => {
      this.stocks = stocks.slice(0, 25);
    });
  }
}
