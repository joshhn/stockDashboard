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
    this.token = storageService.getUser()?.token;
    this.headerOptions = { headers: {Authorization: `Bearer ${this.token}`}};
  }

  getStocks(): Observable<Stock[]> {
    return this.http.get<Stock[]>(`${environment.apiUrl}/stocks`, this.headerOptions);
  }

  getStock(id: number): Observable<Stock> {
    return this.http.get<Stock>(`${environment.apiUrl}/stocks/${id}`, this.headerOptions);
  }
}
