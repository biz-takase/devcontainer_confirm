FROM mysql:9.1.0

RUN microdnf update -y \
    && microdnf install -y glibc-locale-source gzip tzdata \
    && localedef -i ja_JP -c -f UTF-8 -A /usr/share/locale/locale.alias ja_JP.UTF-8 \
    && echo LANG=ja_JP.UTF-8 > /etc/locale.conf \
    && microdnf remove -y glibc-locale-source gzip \
    && microdnf clean all \
    && ln -sf /usr/share/zoneinfo/Asia/Tokyo /etc/localtime

ENV LANG ja_JP.UTF-8
ENV LC_ALL ja_JP.UTF-8
ENV TZ Asia/Tokyo
