import 'dart:ui';

import 'package:flutter/material.dart';
import 'package:flutter_bloc/flutter_bloc.dart';

import 'cart_cubit.dart';
import 'product.dart';

class HomePage extends StatelessWidget {
  HomePage({super.key});

  final List<Product> products = [
    Product(name: "Laptop", price: 10000000),
    Product(name: "Mouse", price: 150000),
    Product(name: "Keyboard", price: 300000),
    Product(name: "Headset", price: 500000),
    Product(name: "Monitor", price: 2500000),
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Stack(
        children: [
          // Background
          Container(
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                begin: Alignment.topLeft,
                end: Alignment.bottomRight,
                colors: [
                  Color(0xFFF8F5F0),
                  Color(0xFFF1ECE5),
                  Color(0xFFE8DED1),
                ],
              ),
            ),
          ),

          SafeArea(
            child: Column(
              children: [
                _buildHeader(context),

                Expanded(
                  child: ListView.builder(
                    padding: const EdgeInsets.symmetric(
                      horizontal: 16,
                      vertical: 8,
                    ),
                    itemCount: products.length,
                    itemBuilder: (context, index) {
                      return _buildProductCard(
                        context,
                        products[index],
                      );
                    },
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeader(BuildContext context) {
    return Padding(
      padding: const EdgeInsets.all(20),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          const Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                "Product Store",
                style: TextStyle(
                  fontSize: 28,
                  fontWeight: FontWeight.bold,
                  color: Color(0xFF3A312A),
                ),
              ),
              SizedBox(height: 4),
              Text(
                "Choose your favorite product",
                style: TextStyle(
                  color: Color(0xFF8A8178),
                  fontSize: 14,
                ),
              ),
            ],
          ),

          BlocBuilder<CartCubit, List<Product>>(
            builder: (context, cart) {
              return Stack(
                children: [
                  glassContainer(
                    width: 60,
                    height: 60,
                    child: const Center(
                      child: Icon(
                        Icons.shopping_cart_rounded,
                        color: Color(0xFF5C4B3C),
                        size: 28,
                      ),
                    ),
                  ),

                  Positioned(
                    right: 0,
                    top: 0,
                    child: CircleAvatar(
                      radius: 10,
                      backgroundColor: const Color(0xFFC08B5C),
                      child: Text(
                        "${cart.length}",
                        style: const TextStyle(
                          color: Colors.white,
                          fontSize: 12,
                        ),
                      ),
                    ),
                  ),
                ],
              );
            },
          ),
        ],
      ),
    );
  }

  Widget _buildProductCard(
    BuildContext context,
    Product product,
  ) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16),
      child: BlocBuilder<CartCubit, List<Product>>(
        builder: (context, cart) {
          final bool inCart = cart.contains(product);

          return glassContainer(
            child: ListTile(
              contentPadding: const EdgeInsets.symmetric(
                horizontal: 16,
                vertical: 8,
              ),

              leading: CircleAvatar(
                backgroundColor: const Color(0xFFE8DED1),
                child: const Icon(
                  Icons.devices_rounded,
                  color: Color(0xFF5C4B3C),
                ),
              ),

              title: Text(
                product.name,
                style: const TextStyle(
                  color: Color(0xFF3A312A),
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                ),
              ),

              subtitle: Text(
                "Rp ${product.price}",
                style: const TextStyle(
                  color: Color(0xFF8A8178),
                ),
              ),

              trailing: ElevatedButton(
                style: ElevatedButton.styleFrom(
                  backgroundColor: inCart
                      ? const Color(0xFFD97C6C)
                      : const Color(0xFFC8B6A6),
                  foregroundColor: Colors.white,
                  elevation: 0,
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(20),
                  ),
                ),
                onPressed: () {
                  if (inCart) {
                    context
                        .read<CartCubit>()
                        .removeProduct(product);
                  } else {
                    context
                        .read<CartCubit>()
                        .addProduct(product);
                  }
                },
                child: Text(
                  inCart ? "Hapus" : "Tambah",
                ),
              ),
            ),
          );
        },
      ),
    );
  }

  Widget glassContainer({
    required Widget child,
    double width = double.infinity,
    double height = 100,
  }) {
    return ClipRRect(
      borderRadius: BorderRadius.circular(24),
      child: BackdropFilter(
        filter: ImageFilter.blur(
          sigmaX: 12,
          sigmaY: 12,
        ),
        child: Container(
          width: width,
          height: height,
          decoration: BoxDecoration(
            color: Colors.white.withValues(alpha: 0.35),
            borderRadius: BorderRadius.circular(24),
            border: Border.all(
              color: Colors.white.withValues(alpha: 0.5),
              width: 1.2,
            ),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withValues(alpha: 0.05),
                blurRadius: 10,
                offset: const Offset(0, 4),
              ),
            ],
          ),
          child: child,
        ),
      ),
    );
  }
}