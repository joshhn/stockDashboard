import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Observable } from 'rxjs';
import { environment } from '../../environments/environment';
import { Stock } from '../models/stock';
import { StorageService } from './storage.service';

@Injectable({
  providedIn: 'root'
})
export class StockService {
  token: string | undefined;
  headerOptions: {};

  constructor(private http: HttpClient, private storageService: StorageService) {
    this.token = this.storageService.getUser()?.token;
    this.headerOptions = { headers: {Authorization: `Bearer ${this.token}`}};
  }

  getStocks(limit: number = 10): Observable<Stock[]> {
    return this.http.get<Stock[]>(`${environment.apiUrl}/stocks?limit=${limit}`, this.headerOptions);
  }

  getStock(ticker: string): Observable<any> {
    return this.http.get<any>(`${environment.apiUrl}/stocks/${ticker}`, this.headerOptions);
  }

  searchStock(query: string = ''): Observable<Stock[]> {
    return this.http.get<Stock[]>(`${environment.apiUrl}/search/stocks?query=${query}`, this.headerOptions);
  }
}
