#ifndef WIDGET_H
#define WIDGET_H

#include <QWidget>
#include <QTimer>
#include <QNetworkAccessManager>
#include <QNetworkRequest>
#include <QNetworkReply>
#include <QEventLoop>
#include <QJsonDocument>
#include <QJsonArray>
#include <QJsonObject>
#include <QUrlQuery>

namespace Ui {
class Widget;
}

class Widget : public QWidget
{
    Q_OBJECT

public:
    explicit Widget(QWidget *parent = 0);
    ~Widget();

    QTimer timerSimple;
    QTimer timerDB;
    QString message,urlWS,bdMain,usrBD,pwdBD;

    void listarRegistros();
    QByteArray sqlQuery(QString sql);
public slots:
    void slotTimerSimple();
    void slotTimerDB();

private:
    Ui::Widget *ui;
};

#endif // WIDGET_H
