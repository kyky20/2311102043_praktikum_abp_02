import 'package:flutter_bloc/flutter_bloc.dart';
import 'product.dart';

class CartCubit extends Cubit<List<Product>> {
  CartCubit() : super([]);

  void addProduct(Product product) {
    final updatedCart = List<Product>.from(state);
    updatedCart.add(product);
    emit(updatedCart);
  }

  void removeProduct(Product product) {
    final updatedCart = List<Product>.from(state);
    updatedCart.remove(product);
    emit(updatedCart);
  }
}