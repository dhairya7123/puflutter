import 'package:flutter/material.dart';
import 'api_service.dart';

class DataDisplay extends StatefulWidget {
  @override
  _DataDisplayState createState() => _DataDisplayState();
}

class _DataDisplayState extends State<DataDisplay> {
  ApiService apiService = ApiService();
  List<Map<String, dynamic>> data = [];

  @override
  void initState() {
    super.initState();
    fetchData();
  }

  void fetchData() async {
    try {
      List<Map<String, dynamic>> fetchedData = await apiService.fetchData();
      setState(() {
        data = fetchedData;
      });
    } catch (e) {
      print(e);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Data Display'),
      ),
      body: ListView.builder(
        itemCount: data.length,
        itemBuilder: (context, index) {
          return Card(
            child: ListTile(
              title: Text(data[index]['column_name']),
              subtitle: Text(data[index]['another_column_name']),
            ),
          );
        },
      ),
    );
  }
}
