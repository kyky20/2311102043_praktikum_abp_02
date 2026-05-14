import 'package:flutter/material.dart';

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      debugShowCheckedModeBanner: false,
      title: 'Modul Flutter',
      home: const HomePage(),
    );
  }
}

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  final List<String> dataBuilder = const [
    'Data Flutter',
    'Data Dart',
    'Data Widget',
    'Data UI',
  ];

  final List<String> dataSeparated = const [
    'Item Pertama',
    'Item Kedua',
    'Item Ketiga',
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Praktikum Modul Flutter'),
        backgroundColor: Colors.orange,
      ),
      body: SingleChildScrollView(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text('1. Container'),
            const SizedBox(height: 8),
            Container(
              width: double.infinity,
              height: 100,
              color: Colors.orange,
              child: const Center(
                child: Text(
                  'Ini Container Berwarna',
                  style: TextStyle(color: Colors.white, fontSize: 18),
                ),
              ),
            ),

            const SizedBox(height: 24),
            const Text('2. GridView'),
            const SizedBox(height: 8),
            GridView.count(
              crossAxisCount: 3,
              shrinkWrap: true,
              physics: const NeverScrollableScrollPhysics(),
              crossAxisSpacing: 10,
              mainAxisSpacing: 10,
              children: List.generate(6, (index) {
                return Container(
                  color: Colors.green,
                  child: Center(
                    child: Text(
                      'Grid ${index + 1}',
                      style: const TextStyle(color: Colors.white),
                    ),
                  ),
                );
              }),
            ),

            const SizedBox(height: 24),
            const Text('3. ListView A, B, C'),
            SizedBox(
              height: 160,
              child: ListView(
                children: const [
                  ListTile(title: Text('A')),
                  ListTile(title: Text('B')),
                  ListTile(title: Text('C')),
                ],
              ),
            ),

            const SizedBox(height: 24),
            const Text('4. ListView.builder'),
            SizedBox(
              height: 220,
              child: ListView.builder(
                itemCount: dataBuilder.length,
                itemBuilder: (context, index) {
                  return Card(
                    child: ListTile(
                      leading: const Icon(Icons.star),
                      title: Text(dataBuilder[index]),
                    ),
                  );
                },
              ),
            ),

            const SizedBox(height: 24),
            const Text('5. ListView.separated'),
            SizedBox(
              height: 180,
              child: ListView.separated(
                itemCount: dataSeparated.length,
                separatorBuilder: (context, index) {
                  return const Divider();
                },
                itemBuilder: (context, index) {
                  return ListTile(
                    title: Text(dataSeparated[index]),
                  );
                },
              ),
            ),

            const SizedBox(height: 24),
            const Text('6. Stack'),
            const SizedBox(height: 8),
            SizedBox(
              height: 160,
              child: Stack(
                children: [
                  Container(
                    width: 160,
                    height: 160,
                    color: Colors.blueGrey,
                  ),
                  Positioned(
                    left: 40,
                    top: 40,
                    child: Container(
                      width: 120,
                      height: 120,
                      color: Colors.amber,
                    ),
                  ),
                  const Positioned(
                    left: 60,
                    top: 80,
                    child: Text(
                      'Ini Stack',
                      style: TextStyle(fontSize: 20),
                    ),
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}