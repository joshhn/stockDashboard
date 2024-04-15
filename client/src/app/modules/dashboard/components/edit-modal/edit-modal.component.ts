import { Component, EventEmitter, Input, Output } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'app-edit-modal',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './edit-modal.component.html',
  styleUrl: './edit-modal.component.css'
})
export class EditModalComponent {
  @Input() name!: string;
  @Output() deleteWatchlist = new EventEmitter<void>();
  @Output() editWatchlist = new EventEmitter<string>();
  @Output() addStock = new EventEmitter<string>();
  @Output() closeModal = new EventEmitter<string>();


  delete() {
    this.deleteWatchlist.emit();
  }

  save() {
    this.editWatchlist.emit(this.name);
    this.name = '';
  }

  addNewStock(stock: string) {
    this.addStock.emit(stock);
  }

  close() {
    this.closeModal.emit();
  }
}
