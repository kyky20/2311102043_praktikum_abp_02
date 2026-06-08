import 'package:flutter/material.dart';
import 'package:flutter_test/flutter_test.dart';
import 'package:todo_2311102043/main.dart';

void main() {
  testWidgets('adds a task with Provider state', (WidgetTester tester) async {
    final notificationProvider = NotificationProvider();

    await tester.pumpWidget(
      TodoApp(notificationProvider: notificationProvider),
    );

    expect(find.text('Total tugas: 0'), findsOneWidget);

    await tester.enterText(find.byType(TextField), 'Belajar Provider dan FCM');
    await tester.tap(find.text('Tambah'));
    await tester.pump();

    expect(find.text('Total tugas: 1'), findsOneWidget);
    expect(find.text('Belajar Provider dan FCM'), findsOneWidget);
  });
}
