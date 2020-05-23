#include "widget.h"
#include "ui_widget.h"

Widget::Widget(QWidget *parent) :
    QWidget(parent),
    ui(new Ui::Widget)
{
    ui->setupUi(this);

    urlWS="http://www.mi-server-de-pruebas.com/for_Navjeet/multipleTimer/webservice/webservice.php";
    bdMain="miserver_countries";
    usrBD="miserver_admin";
    pwdBD="#W0UliZsJZsu";

    connect(&timerSimple, SIGNAL(timeout()), this, SLOT(slotTimerSimple()));
    connect(&timerDB, SIGNAL(timeout()), this, SLOT(slotTimerDB()));

    timerSimple.start(2000); // shots every 2 seg
    timerDB.start(5000); // shots every 5 seg
}

Widget::~Widget()
{
    timerSimple.stop();
    timerDB.stop();

    disconnect(&timerSimple, SIGNAL(timeout()), this, SLOT(slotTimerSimple()));
    disconnect(&timerDB, SIGNAL(timeout()), this, SLOT(slotTimerDB()));

    delete ui;
}

QByteArray Widget::sqlQuery(QString sql)
{
    QNetworkAccessManager networkManager;
    QNetworkReply *networkReply;
    QNetworkRequest networkRequest;
    QByteArray postData;
    QUrlQuery urlQuery;
    QEventLoop qEventLoop;

    networkRequest.setUrl(QUrl(urlWS));
    urlQuery.addQueryItem("sql",sql);
    urlQuery.addQueryItem("bd",bdMain);
    urlQuery.addQueryItem("usr_bd",usrBD);
    urlQuery.addQueryItem("pwd_bd",pwdBD);
    postData.append(urlQuery.toString());
    networkRequest.setHeader(QNetworkRequest::ContentTypeHeader,"application/x-www-form-urlencoded;charset=UTF-8");
    networkRequest.setHeader(QNetworkRequest::ContentLengthHeader,postData.length());
    networkReply = networkManager.post(networkRequest,postData);

    connect(networkReply,SIGNAL(finished()),&qEventLoop,SLOT(quit()));
    qEventLoop.exec();
    disconnect(networkReply,SIGNAL(finished()),&qEventLoop,SLOT(quit()));

    postData=networkReply->readAll();
    delete networkReply;
    return postData;
}

void Widget::listarRegistros()
{
    QByteArray postData;
    QJsonDocument jsonDocument;
    QJsonArray jsonArray;
    QJsonObject jsonObject;
    QString sql,qString;
    QStringList stringList;
    QModelIndex currentIndex;
    int j,cuantos;

    stringList << "N" << "COUNTRY" << "CAPITAL";
    currentIndex=ui->tableWidget->currentIndex();
    ui->tableWidget->clearContents();
    ui->tableWidget->setRowCount(0);
    ui->tableWidget->setColumnCount(3);
    ui->tableWidget->setHorizontalHeaderLabels(stringList);
    ui->tableWidget->setColumnWidth(0,50);
    ui->tableWidget->setColumnWidth(1,150);
    ui->tableWidget->setColumnWidth(2,350);

    sql="select * from `countries list`";
    postData=sqlQuery(sql);

    jsonDocument = QJsonDocument::fromJson(postData);
    jsonArray=jsonDocument.array();
    if (jsonArray.isEmpty())
    {
        return;
    }
    cuantos=jsonArray.count();
    ui->tableWidget->setRowCount(cuantos);

    for (j=0; j<cuantos; j++)
    {
        jsonObject=jsonArray[j].toObject();
        qString=jsonObject.value("icountry").toString();
        ui->tableWidget->setItem(j,0,new QTableWidgetItem(qString));

        qString=jsonObject.value("country").toString();
        ui->tableWidget->setItem(j,1,new QTableWidgetItem(qString));

        qString=jsonObject.value("capital").toString();
        ui->tableWidget->setItem(j,2,new QTableWidgetItem(qString));
    }
    ui->tableWidget->setCurrentIndex(currentIndex);
    ui->tableWidget->setFocus();
}

void Widget::slotTimerSimple()
{
    if (message=="Hello")
    {
        message="Navjeet";
    }
    else
    {
        message="Hello";
    }

    setWindowTitle(message);
}

void Widget::slotTimerDB()
{
    listarRegistros();
}
